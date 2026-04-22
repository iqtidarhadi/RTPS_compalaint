<?php

namespace Modules\Complaint\Services;

use Illuminate\Support\Facades\DB;
use Modules\Complaint\Enums\ComplaintDecision;
use Modules\Complaint\Enums\ComplaintStage;
use Modules\Complaint\Enums\ComplaintStatus;
use Modules\Complaint\Models\Appeal;
use Modules\Complaint\Models\Complaint;
use Modules\Complaint\Models\ComplaintHistory;
use Modules\Complaint\Models\ComplaintStatusHistory;
use Modules\Complaint\Models\Penalty;

class ComplaintWorkflowService
{
    public function markAsSubmitted(Complaint $complaint, $actor = null, ?string $remarks = null): Complaint
    {
        return $this->transitionComplaint(
            complaint: $complaint,
            status: ComplaintStatus::SUBMITTED->value,
            level: ComplaintStage::SPO->value,
            role: 'citizen',
            decision: 'submitted',
            actor: $actor,
            remarks: $remarks ?? 'Citizen submitted complaint.'
        );
    }

    public function processDecision(
        Complaint $complaint,
        string $stage,
        string $decision,
        $actor = null,
        ?string $remarks = null,
        ?float $penaltyAmount = null,
        ?string $penaltyReason = null
    ): Complaint {
        $decision = ComplaintDecision::from($decision)->value;

        return match ($stage) {
            ComplaintStage::SPO->value => $this->handleSpoDecision(
                $complaint,
                $decision,
                $actor,
                $remarks
            ),
            ComplaintStage::APPELLATE_AUTHORITY->value => $this->handleAppellateDecision(
                $complaint,
                $decision,
                $actor,
                $remarks,
                $penaltyAmount,
                $penaltyReason
            ),
            ComplaintStage::CITIZEN->value => $this->moveToRtsCommission($complaint, $actor, $remarks),
            ComplaintStage::RTS_COMMISSION->value => $this->handleRtsDecision(
                $complaint,
                $decision,
                $actor,
                $remarks,
                $penaltyAmount,
                $penaltyReason
            ),
            default => throw new \InvalidArgumentException("Unsupported workflow stage [{$stage}]."),
        };
    }

    public function moveToRtsCommission(Complaint $complaint, $actor = null, ?string $remarks = null): Complaint
    {
        return $this->transitionComplaint(
            complaint: $complaint,
            status: ComplaintStatus::SENT_TO_RTS_COMMISSION->value,
            level: ComplaintStage::RTS_COMMISSION->value,
            role: 'citizen',
            decision: ComplaintDecision::APPEAL_AGAIN->value,
            actor: $actor,
            remarks: $remarks ?? 'Citizen appealed again to RTS Commission.'
        );
    }

    public function createAppealRecord(Complaint $complaint, array $data, $actor = null): Appeal
    {
        return $complaint->appeals()->create([
            'complainant_id' => $complaint->complainant_id,
            'appeal_by' => $actor?->id ?? $complaint->citizen_id,
            'appeal_level' => $complaint->appeals()->count() + 1,
            'remarks' => $data['appeal_description'] ?? $data['remarks'] ?? null,
            'first_appeal_date' => $data['first_appeal_date'] ?? now()->toDateString(),
            'appeal_description' => $data['appeal_description'] ?? $data['remarks'] ?? 'Complaint appealed again.',
            'status' => 'pending',
        ]);
    }

    public function getAllowedDecisions(Complaint $complaint): array
    {
        $stage = $complaint->current_stage ?: $complaint->current_level;

        return match ($stage) {
            ComplaintStage::SPO->value => [
                ComplaintDecision::IN_PROGRESS->value,
                ComplaintDecision::COMPLETED->value,
                ComplaintDecision::DELAYED->value,
                ComplaintDecision::REJECTED->value,
            ],
            ComplaintStage::APPELLATE_AUTHORITY->value => [
                ComplaintDecision::INVALID_JUSTIFICATION->value,
                ComplaintDecision::VALID_JUSTIFICATION->value,
            ],
            ComplaintStage::CITIZEN->value => $complaint->status === ComplaintStatus::REJECTED->value
                ? [ComplaintDecision::APPEAL_AGAIN->value]
                : [],
            ComplaintStage::RTS_COMMISSION->value => [
                ComplaintDecision::INVALID_JUSTIFICATION->value,
                ComplaintDecision::VALID_JUSTIFICATION->value,
            ],
            default => [],
        };
    }

    protected function handleSpoDecision(
        Complaint $complaint,
        string $decision,
        $actor,
        ?string $remarks
    ): Complaint {
        return match ($decision) {
            ComplaintDecision::IN_PROGRESS->value => $this->transitionComplaint(
                complaint: $complaint,
                status: ComplaintStatus::IN_PROGRESS->value,
                level: ComplaintStage::SPO->value,
                role: 'spo',
                decision: $decision,
                actor: $actor,
                remarks: $remarks ?? 'Complaint marked as in progress by SPO.'
            ),
            ComplaintDecision::COMPLETED->value => $this->transitionComplaint(
                complaint: $complaint,
                status: ComplaintStatus::CLOSED->value,
                level: ComplaintStage::CLOSED->value,
                role: 'spo',
                decision: $decision,
                actor: $actor,
                remarks: $remarks ?? 'Complaint completed by SPO and closed successfully.'
            ),
            ComplaintDecision::DELAYED->value => $this->transitionComplaint(
                complaint: $complaint,
                status: ComplaintStatus::SENT_TO_APPELLATE_AUTHORITY->value,
                level: ComplaintStage::APPELLATE_AUTHORITY->value,
                role: 'spo',
                decision: $decision,
                actor: $actor,
                remarks: $remarks ?? 'Complaint delayed and forwarded to Appellate Authority.'
            ),
            ComplaintDecision::REJECTED->value => $this->transitionComplaint(
                complaint: $complaint,
                status: ComplaintStatus::REJECTED->value,
                level: ComplaintStage::APPELLATE_AUTHORITY->value,
                role: 'spo',
                decision: $decision,
                actor: $actor,
                remarks: $remarks ?? 'Complaint rejected by SPO and forwarded to Appellate Authority.'
            ),
            default => throw new \InvalidArgumentException("Unsupported SPO decision [{$decision}]."),
        };
    }

    protected function handleAppellateDecision(
        Complaint $complaint,
        string $decision,
        $actor,
        ?string $remarks,
        ?float $penaltyAmount,
        ?string $penaltyReason
    ): Complaint {
        return match ($decision) {
            ComplaintDecision::INVALID_JUSTIFICATION->value => $this->transitionWithPenalty(
                complaint: $complaint,
                status: ComplaintStatus::PENALTY_APPLIED->value,
                level: ComplaintStage::CLOSED->value,
                role: 'appellate_authority',
                decision: $decision,
                actor: $actor,
                remarks: $remarks ?? 'Appellate Authority found invalid justification. Service + penalty applied.',
                penaltyAmount: $penaltyAmount,
                penaltyReason: $penaltyReason
            ),
            ComplaintDecision::VALID_JUSTIFICATION->value => $this->transitionComplaint(
                complaint: $complaint,
                status: ComplaintStatus::REJECTED->value,
                level: ComplaintStage::CITIZEN->value,
                role: 'appellate_authority',
                decision: $decision,
                actor: $actor,
                remarks: $remarks ?? 'Appellate Authority accepted the justification and rejected the complaint.'
            ),
            default => throw new \InvalidArgumentException("Unsupported appellate decision [{$decision}]."),
        };
    }

    protected function handleRtsDecision(
        Complaint $complaint,
        string $decision,
        $actor,
        ?string $remarks,
        ?float $penaltyAmount,
        ?string $penaltyReason
    ): Complaint {
        return match ($decision) {
            ComplaintDecision::INVALID_JUSTIFICATION->value => $this->transitionWithPenalty(
                complaint: $complaint,
                status: ComplaintStatus::PENALTY_APPLIED->value,
                level: ComplaintStage::CLOSED->value,
                role: 'rts_commission',
                decision: $decision,
                actor: $actor,
                remarks: $remarks ?? 'RTS Commission found invalid justification. Service + penalty applied.',
                penaltyAmount: $penaltyAmount,
                penaltyReason: $penaltyReason
            ),
            ComplaintDecision::VALID_JUSTIFICATION->value => $this->transitionComplaint(
                complaint: $complaint,
                status: ComplaintStatus::REJECTED->value,
                level: ComplaintStage::CLOSED->value,
                role: 'rts_commission',
                decision: $decision,
                actor: $actor,
                remarks: $remarks ?? 'RTS Commission accepted the justification and rejected the complaint.'
            ),
            default => throw new \InvalidArgumentException("Unsupported RTS decision [{$decision}]."),
        };
    }

    protected function transitionWithPenalty(
        Complaint $complaint,
        string $status,
        string $level,
        string $role,
        string $decision,
        $actor,
        ?string $remarks,
        ?float $penaltyAmount,
        ?string $penaltyReason
    ): Complaint {
        return DB::transaction(function () use (
            $complaint,
            $status,
            $level,
            $role,
            $decision,
            $actor,
            $remarks,
            $penaltyAmount,
            $penaltyReason
        ) {
            $updatedComplaint = $this->transitionComplaint(
                complaint: $complaint,
                status: $status,
                level: $level,
                role: $role,
                decision: $decision,
                actor: $actor,
                remarks: $remarks,
                penaltyAmount: $penaltyAmount
            );

            Penalty::create([
                'complaint_id' => $complaint->id,
                'officer_id' => $actor?->id,
                'amount' => $penaltyAmount ?? 0,
                'reason' => $penaltyReason ?: ($remarks ?: 'Penalty imposed through workflow decision.'),
                'status' => 'imposed',
            ]);

            return $updatedComplaint;
        });
    }

    protected function transitionComplaint(
        Complaint $complaint,
        string $status,
        string $level,
        string $role,
        string $decision,
        $actor = null,
        ?string $remarks = null,
        ?float $penaltyAmount = null
    ): Complaint {
        return DB::transaction(function () use ($complaint, $status, $level, $role, $decision, $actor, $remarks, $penaltyAmount) {
            $oldStatus = $complaint->status;

            $complaint->fill([
                'status' => $status,
                'current_level' => $level,
                'current_stage' => $level,
                'tracking_number' => $complaint->tracking_number ?: $complaint->complaint_number,
                'last_updated_at' => now(),
                'submitted_at' => $complaint->submitted_at ?: now(),
                'decision_notes' => $remarks,
                'resolution_details' => $remarks,
                'penalty_amount' => $penaltyAmount,
            ]);

            if (in_array($status, [
                ComplaintStatus::PENALTY_APPLIED->value,
                ComplaintStatus::RESOLVED->value,
                ComplaintStatus::CLOSED->value,
            ], true)) {
                $complaint->resolved_at = now();
            }

            $complaint->save();

            ComplaintHistory::create([
                'complaint_id' => $complaint->id,
                'action_by' => $actor?->id ?? $complaint->citizen_id,
                'role' => $role,
                'decision' => $decision,
                'remarks' => $remarks,
                'penalty_amount' => $penaltyAmount,
            ]);

            ComplaintStatusHistory::create([
                'complaint_id' => $complaint->id,
                'complaint_number' => $complaint->complaint_number,
                'old_status' => $this->normalizeHistoryStatus($oldStatus),
                'new_status' => $this->normalizeHistoryStatus($status),
                'remarks' => $remarks,
                'internal_notes' => 'Stage: ' . $level,
                'changed_by' => $actor?->id ?? $complaint->citizen_id,
                'changed_by_name' => $this->resolveActorName($actor),
                'changed_by_role' => $role,
                'changed_at' => now(),
                'time_taken_hours' => $oldStatus && $complaint->created_at
                    ? $complaint->created_at->diffInHours(now())
                    : null,
            ]);

            return $complaint->fresh(['appeals', 'histories', 'penalties', 'statusHistory']);
        });
    }

    protected function resolveActorName($actor): string
    {
        if (!$actor) {
            return 'System';
        }

        foreach (['name', 'firstname'] as $property) {
            if (!empty($actor->{$property})) {
                $lastName = $property === 'firstname' && !empty($actor->lastname)
                    ? ' ' . $actor->lastname
                    : '';

                return trim($actor->{$property} . $lastName);
            }
        }

        return 'System';
    }

    protected function normalizeHistoryStatus(?string $status): ?string
    {
        return match ($status) {
            ComplaintStatus::DELAYED->value => ComplaintStatusHistory::STATUS_PENDING,
            ComplaintStatus::COMPLETED->value => ComplaintStatusHistory::STATUS_RESOLVED,
            ComplaintStatus::SENT_TO_APPELLATE_AUTHORITY->value => ComplaintStatusHistory::STATUS_REJECTED,
            ComplaintStatus::SENT_TO_RTS_COMMISSION->value => ComplaintStatusHistory::STATUS_APPEALED,
            ComplaintStatus::PENALTY_APPLIED->value => ComplaintStatusHistory::STATUS_RESOLVED,
            default => $status,
        };
    }
}
