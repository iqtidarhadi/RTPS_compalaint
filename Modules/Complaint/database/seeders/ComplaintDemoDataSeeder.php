<?php

namespace Modules\Complaint\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Modules\Complaint\Models\Appeal;
use Modules\Complaint\Models\Complaint;
use Modules\Complaint\Models\ComplaintHistory;
use Modules\Complaint\Models\ComplaintStatusHistory;
use Modules\Complaint\Models\Complainant;
use Modules\Complaint\Models\Department;
use Modules\Complaint\Models\Penalty;
use Modules\Complaint\Models\Service;
use Spatie\Permission\Models\Role;

class ComplaintDemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $hasUserTypeColumn = Schema::hasColumn('users', 'user_type');
        $hasCnicColumn = Schema::hasColumn('users', 'cnic_no');
        $hasContactColumn = Schema::hasColumn('users', 'contact_no');
        $hasAddressColumn = Schema::hasColumn('users', 'address');
        $hasCitizenIdColumn = Schema::hasColumn('complaints', 'citizen_id');
        $hasCurrentLevelColumn = Schema::hasColumn('complaints', 'current_level');
        $hasTrackingNumberColumn = Schema::hasColumn('complaints', 'tracking_number');
        $hasAppealByColumn = Schema::hasColumn('appeals', 'appeal_by');
        $hasAppealLevelColumn = Schema::hasColumn('appeals', 'appeal_level');
        $hasAppealRemarksColumn = Schema::hasColumn('appeals', 'remarks');

        $departments = Department::query()->with('services')->get()->keyBy('name');

        if ($departments->isEmpty()) {
            return;
        }

        $citizens = collect([
            [
                'firstname' => 'Ali',
                'lastname' => 'Khan',
                'email' => 'citizen.ali@example.com',
                'cnic_number' => '17301-1234567-1',
                'contact_number' => '03001112221',
                'district' => 'Peshawar',
                'province' => 'Khyber Pakhtunkhwa',
                'postal_address' => 'University Road, Peshawar',
            ],
            [
                'firstname' => 'Sana',
                'lastname' => 'Bibi',
                'email' => 'citizen.sana@example.com',
                'cnic_number' => '17301-1234567-2',
                'contact_number' => '03002223332',
                'district' => 'Peshawar',
                'province' => 'Khyber Pakhtunkhwa',
                'postal_address' => 'Hayatabad, Peshawar',
            ],
            [
                'firstname' => 'Usman',
                'lastname' => 'Shah',
                'email' => 'citizen.usman@example.com',
                'cnic_number' => '17301-1234567-3',
                'contact_number' => '03003334443',
                'district' => 'Peshawar',
                'province' => 'Khyber Pakhtunkhwa',
                'postal_address' => 'Ring Road, Peshawar',
            ],
        ])->map(function (array $citizenData) use ($hasUserTypeColumn, $hasCnicColumn, $hasContactColumn, $hasAddressColumn) {
            $user = User::query()->firstOrNew(['email' => $citizenData['email']]);
            $payload = [
                'firstname' => $citizenData['firstname'],
                'lastname' => $citizenData['lastname'],
                'email' => $citizenData['email'],
                'password' => Hash::make('password'),
                'is_active' => true,
                'email_verified_at' => now(),
            ];

            if ($hasUserTypeColumn) {
                $payload['user_type'] = 'citizen';
            }

            if ($hasCnicColumn) {
                $payload['cnic_no'] = $citizenData['cnic_number'];
            }

            if ($hasContactColumn) {
                $payload['contact_no'] = $citizenData['contact_number'];
            }

            if ($hasAddressColumn) {
                $payload['address'] = $citizenData['postal_address'];
            }

            $user->forceFill($payload)->save();
            $user->syncRoles([Role::findOrCreate('Citizen', 'web')]);

            $complainant = Complainant::query()->firstOrNew(['email' => $citizenData['email']]);
            $complainant->fill([
                'cnic_number' => $citizenData['cnic_number'],
                'name' => $citizenData['firstname'] . ' ' . $citizenData['lastname'],
                'gender' => 'male',
                'contact_number' => $citizenData['contact_number'],
                'id_type' => 'cnic',
                'email' => $citizenData['email'],
                'province' => $citizenData['province'],
                'district' => $citizenData['district'],
                'postal_address' => $citizenData['postal_address'],
                'email_verified_at' => now(),
            ])->save();

            return [
                'user' => $user,
                'complainant' => $complainant,
            ];
        })->values();

        $scenarios = [
            [
                'title' => 'Birth certificate issuance delay',
                'department' => 'Municipal Department',
                'service' => 'Birth Certificate',
                'citizen_index' => 0,
                'category' => 'Document Delay',
                'priority' => 'high',
                'description' => 'The birth certificate request is still pending after the committed SLA.',
                'address' => 'Tehkal Bala, Peshawar',
                'flow' => [],
            ],
            [
                'title' => 'Property transfer pending with SPO',
                'department' => 'Municipal Department',
                'service' => 'Property Transfer',
                'citizen_index' => 1,
                'category' => 'Transfer Delay',
                'priority' => 'medium',
                'description' => 'Property transfer file is not moving beyond the initial office review.',
                'address' => 'Board Bazaar, Peshawar',
                'flow' => [],
            ],
            [
                'title' => 'Police clearance completed successfully',
                'department' => 'Police Department',
                'service' => 'Police Clearance Certificate',
                'citizen_index' => 2,
                'category' => 'Certificate Request',
                'priority' => 'medium',
                'description' => 'Citizen requested fast processing of police clearance certificate.',
                'address' => 'City Police Lines, Peshawar',
                'flow' => [
                    ['stage' => Complaint::LEVEL_SPO, 'decision' => 'completed', 'remarks' => 'Application completed at SPO level.'],
                ],
            ],
            [
                'title' => 'Hospital service complaint resolved by appellate authority',
                'department' => 'Health Department',
                'service' => 'Hospital Service Complaint',
                'citizen_index' => 0,
                'category' => 'Service Quality',
                'priority' => 'urgent',
                'description' => 'Citizen reported persistent delays and non-cooperation at the hospital front desk.',
                'address' => 'Lady Reading Hospital, Peshawar',
                'flow' => [
                    ['stage' => Complaint::LEVEL_SPO, 'decision' => 'rejected', 'remarks' => 'SPO rejected due to internal note mismatch.'],
                    ['stage' => Complaint::LEVEL_APPELLATE_AUTHORITY, 'decision' => 'invalid_justification', 'remarks' => 'Appellate authority found the departmental justification invalid.', 'penalty_amount' => 1500, 'penalty_reason' => 'Delay without lawful justification.'],
                ],
            ],
            [
                'title' => 'School leaving certificate rejected after appellate review',
                'department' => 'Education Department',
                'service' => 'School Leaving Certificate',
                'citizen_index' => 1,
                'category' => 'Certificate Issue',
                'priority' => 'high',
                'description' => 'The school refused to issue the leaving certificate despite full documentation.',
                'address' => 'Warsak Road, Peshawar',
                'flow' => [
                    ['stage' => Complaint::LEVEL_SPO, 'decision' => 'rejected', 'remarks' => 'SPO rejected after initial document review.'],
                    ['stage' => Complaint::LEVEL_APPELLATE_AUTHORITY, 'decision' => 'valid_justification', 'remarks' => 'Appellate authority accepted the departmental justification.'],
                ],
                'appeal_to_rts' => true,
                'rts_decision' => ['decision' => 'invalid_justification', 'remarks' => 'RTS found the appellate justification invalid and resolved the matter.', 'penalty_amount' => 2500, 'penalty_reason' => 'Improper refusal of certificate issuance.'],
            ],
            [
                'title' => 'Emergency response complaint pending at RTS',
                'department' => 'Fire Brigade',
                'service' => 'Emergency Response Complaint',
                'citizen_index' => 2,
                'category' => 'Emergency Delay',
                'priority' => 'urgent',
                'description' => 'Fire response team reached the site too late and the citizen escalated the matter.',
                'address' => 'Industrial Estate, Peshawar',
                'flow' => [
                    ['stage' => Complaint::LEVEL_SPO, 'decision' => 'rejected', 'remarks' => 'SPO closed the complaint without field validation.'],
                    ['stage' => Complaint::LEVEL_APPELLATE_AUTHORITY, 'decision' => 'valid_justification', 'remarks' => 'Appellate authority upheld the departmental response.'],
                ],
                'appeal_to_rts' => true,
            ],
        ];

        foreach ($scenarios as $scenario) {
            if (Complaint::query()->where('title', $scenario['title'])->exists()) {
                continue;
            }

            $department = $departments->get($scenario['department']);
            $service = $department?->services->firstWhere('service_name', $scenario['service']);

            if (!$department || !$service instanceof Service) {
                continue;
            }

            $citizenRecord = $citizens->get($scenario['citizen_index']);
            $citizen = $citizenRecord['user'];
            $complainant = $citizenRecord['complainant'];

            $complaintPayload = [
                'citizen_id' => $citizen->id,
                'complainant_id' => $complainant->id,
                'service_id' => $service->id,
                'department_id' => $department->id,
                'category' => $scenario['category'],
                'address_location' => $scenario['address'],
                'title' => $scenario['title'],
                'description' => $scenario['description'],
                'priority' => $scenario['priority'],
                'status' => ComplaintStatusHistory::STATUS_PENDING,
                'current_level' => Complaint::LEVEL_CITIZEN,
                'submitted_at' => now()->subDays(random_int(2, 20)),
            ];

            if (!$hasCitizenIdColumn) {
                unset($complaintPayload['citizen_id']);
            }

            if (!$hasCurrentLevelColumn) {
                unset($complaintPayload['current_level']);
            }

            if ($hasTrackingNumberColumn) {
                $complaintPayload['tracking_number'] = null;
            }

            $complaint = Complaint::query()->create($complaintPayload);
            $this->recordTransition(
                complaint: $complaint,
                oldStatus: null,
                newStatus: ComplaintStatusHistory::STATUS_PENDING,
                role: 'citizen',
                decision: 'submitted',
                actor: $citizen,
                remarks: 'Complaint submitted through seeded workflow data.',
                level: Complaint::LEVEL_SPO
            );

            foreach ($scenario['flow'] as $transition) {
                $actor = $this->resolveActor($transition['stage'], $department->name);
                [$status, $level, $role] = $this->mapDecision($transition['stage'], $transition['decision']);

                $complaint = $this->recordTransition(
                    complaint: $complaint,
                    oldStatus: $complaint->status,
                    newStatus: $status,
                    role: $role,
                    decision: $transition['decision'],
                    actor: $actor,
                    remarks: $transition['remarks'] ?? null,
                    level: $level,
                    penaltyAmount: $transition['penalty_amount'] ?? null,
                    penaltyReason: $transition['penalty_reason'] ?? null
                );
            }

            if (!empty($scenario['appeal_to_rts'])) {
                $appealPayload = [
                    'complaint_id' => $complaint->id,
                    'complainant_id' => $complainant->id,
                    'appeal_by' => $citizen->id,
                    'appeal_level' => 1,
                    'remarks' => 'Citizen escalated complaint to RTS Commission.',
                    'first_appeal_date' => now()->toDateString(),
                    'appeal_description' => 'Citizen requested RTS Commission review after appellate rejection.',
                    'status' => 'pending',
                ];

                if (!$hasAppealByColumn) {
                    unset($appealPayload['appeal_by']);
                }

                if (!$hasAppealLevelColumn) {
                    unset($appealPayload['appeal_level']);
                }

                if (!$hasAppealRemarksColumn) {
                    unset($appealPayload['remarks']);
                }

                Appeal::query()->create($appealPayload);

                $complaint = $this->recordTransition(
                    complaint: $complaint,
                    oldStatus: $complaint->status,
                    newStatus: ComplaintStatusHistory::STATUS_APPEALED,
                    role: 'citizen',
                    decision: 'appeal_again',
                    actor: $citizen,
                    remarks: 'Citizen escalated complaint to RTS Commission.',
                    level: Complaint::LEVEL_RTS_COMMISSION
                );
            }

            if (!empty($scenario['rts_decision'])) {
                $rtsOfficer = $this->resolveActor(Complaint::LEVEL_RTS_COMMISSION, null);
                [$status, $level, $role] = $this->mapDecision(
                    Complaint::LEVEL_RTS_COMMISSION,
                    $scenario['rts_decision']['decision']
                );

                $this->recordTransition(
                    complaint: $complaint,
                    oldStatus: $complaint->status,
                    newStatus: $status,
                    role: $role,
                    decision: $scenario['rts_decision']['decision'],
                    actor: $rtsOfficer,
                    remarks: $scenario['rts_decision']['remarks'] ?? null,
                    level: $level,
                    penaltyAmount: $scenario['rts_decision']['penalty_amount'] ?? null,
                    penaltyReason: $scenario['rts_decision']['penalty_reason'] ?? null
                );
            }
        }
    }

    protected function resolveActor(string $stage, ?string $departmentName): ?User
    {
        $roleName = match ($stage) {
            Complaint::LEVEL_SPO => 'Service Point Officer',
            Complaint::LEVEL_APPELLATE_AUTHORITY => 'Appellate Authority',
            Complaint::LEVEL_RTS_COMMISSION => 'RTS Commission Officer',
            default => null,
        };

        if (!$roleName) {
            return null;
        }

        $query = User::role($roleName);

        if ($departmentName && $roleName !== 'RTS Commission Officer') {
            $query->where('lastname', $departmentName);
        }

        return $query->first();
    }

    protected function mapDecision(string $stage, string $decision): array
    {
        return match ([$stage, $decision]) {
            [Complaint::LEVEL_SPO, 'completed'] => [ComplaintStatusHistory::STATUS_RESOLVED, Complaint::LEVEL_CLOSED, 'spo'],
            [Complaint::LEVEL_SPO, 'rejected'] => [ComplaintStatusHistory::STATUS_REJECTED, Complaint::LEVEL_APPELLATE_AUTHORITY, 'spo'],
            [Complaint::LEVEL_APPELLATE_AUTHORITY, 'invalid_justification'] => [ComplaintStatusHistory::STATUS_RESOLVED, Complaint::LEVEL_CLOSED, 'appellate_authority'],
            [Complaint::LEVEL_APPELLATE_AUTHORITY, 'valid_justification'] => [ComplaintStatusHistory::STATUS_REJECTED, Complaint::LEVEL_CITIZEN, 'appellate_authority'],
            [Complaint::LEVEL_RTS_COMMISSION, 'invalid_justification'] => [ComplaintStatusHistory::STATUS_RESOLVED, Complaint::LEVEL_CLOSED, 'rts_commission'],
            [Complaint::LEVEL_RTS_COMMISSION, 'valid_justification'] => [ComplaintStatusHistory::STATUS_REJECTED, Complaint::LEVEL_CLOSED, 'rts_commission'],
            default => [ComplaintStatusHistory::STATUS_PENDING, Complaint::LEVEL_SPO, 'citizen'],
        };
    }

    protected function recordTransition(
        Complaint $complaint,
        ?string $oldStatus,
        string $newStatus,
        string $role,
        string $decision,
        ?User $actor,
        ?string $remarks,
        string $level,
        ?float $penaltyAmount = null,
        ?string $penaltyReason = null
    ): Complaint {
        $complaintUpdate = [
            'status' => $newStatus,
            'last_updated_at' => now(),
        ];

        if (Schema::hasColumn('complaints', 'current_level')) {
            $complaintUpdate['current_level'] = $level;
        }

        if ($newStatus === ComplaintStatusHistory::STATUS_RESOLVED) {
            $complaintUpdate['resolved_at'] = now();
        }

        $complaint->forceFill($complaintUpdate)->save();

        ComplaintStatusHistory::query()->create([
            'complaint_id' => $complaint->id,
            'complaint_number' => $complaint->complaint_number,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'remarks' => $remarks,
            'internal_notes' => 'Level: ' . $level,
            'changed_by' => $actor?->id,
            'changed_by_name' => $this->resolveActorName($actor),
            'changed_by_role' => $role,
            'changed_at' => now(),
            'time_taken_hours' => null,
        ]);

        ComplaintHistory::query()->create([
            'complaint_id' => $complaint->id,
            'action_by' => $actor?->id,
            'role' => $role,
            'decision' => $decision,
            'remarks' => $remarks,
            'penalty_amount' => $penaltyAmount,
        ]);

        if ($penaltyAmount !== null) {
            Penalty::query()->create([
                'complaint_id' => $complaint->id,
                'officer_id' => $actor?->id,
                'amount' => $penaltyAmount,
                'reason' => $penaltyReason ?: ($remarks ?: 'Penalty imposed during seeded workflow.'),
                'status' => 'imposed',
            ]);
        }

        return $complaint->fresh();
    }

    protected function resolveActorName(?User $actor): string
    {
        if (!$actor) {
            return 'System';
        }

        return trim(($actor->firstname ?? '') . ' ' . ($actor->lastname ?? '')) ?: ($actor->email ?? 'System');
    }
}
