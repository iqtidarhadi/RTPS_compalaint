<?php

namespace Modules\Complaint\Enums;

enum ComplaintStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case PENDING = 'pending';
    case UNDER_REVIEW = 'under_review';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case DELAYED = 'delayed';
    case RESOLVED = 'resolved';
    case REJECTED = 'rejected';
    case APPEALED = 'appealed';
    case SENT_TO_APPELLATE_AUTHORITY = 'sent_to_appellate_authority';
    case SENT_TO_RTS_COMMISSION = 'sent_to_rts_commission';
    case PENALTY_APPLIED = 'penalty_applied';
    case CLOSED = 'closed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::SUBMITTED => 'Submitted',
            self::PENDING => 'Pending',
            self::UNDER_REVIEW => 'Under Review',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
            self::DELAYED => 'Delayed',
            self::RESOLVED => 'Resolved',
            self::REJECTED => 'Rejected',
            self::APPEALED => 'Appealed',
            self::SENT_TO_APPELLATE_AUTHORITY => 'Sent to Appellate Authority',
            self::SENT_TO_RTS_COMMISSION => 'Sent to RTS Commission',
            self::PENALTY_APPLIED => 'Penalty Applied',
            self::CLOSED => 'Closed',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::SUBMITTED => 'bg-primary-subtle text-primary',
            self::PENDING,
            self::DELAYED => 'bg-warning-subtle text-warning',
            self::UNDER_REVIEW,
            self::IN_PROGRESS,
            self::SENT_TO_APPELLATE_AUTHORITY,
            self::SENT_TO_RTS_COMMISSION => 'bg-info-subtle text-info',
            self::COMPLETED,
            self::RESOLVED,
            self::CLOSED,
            self::PENALTY_APPLIED => 'bg-success-subtle text-success',
            self::REJECTED => 'bg-danger-subtle text-danger',
            self::APPEALED => 'bg-dark-subtle text-dark',
            default => 'bg-secondary-subtle text-secondary',
        };
    }

    public function countsAsResolved(): bool
    {
        return in_array($this, [
            self::COMPLETED,
            self::RESOLVED,
            self::PENALTY_APPLIED,
            self::CLOSED,
        ], true);
    }

    public function isEscalated(): bool
    {
        return in_array($this, [
            self::SENT_TO_APPELLATE_AUTHORITY,
            self::SENT_TO_RTS_COMMISSION,
            self::APPEALED,
        ], true);
    }
}
