<?php

namespace Modules\Complaint\Enums;

enum ComplaintDecision: string
{
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case DELAYED = 'delayed';
    case REJECTED = 'rejected';
    case INVALID_JUSTIFICATION = 'invalid_justification';
    case VALID_JUSTIFICATION = 'valid_justification';
    case APPEAL_AGAIN = 'appeal_again';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::IN_PROGRESS => 'Mark In Progress',
            self::COMPLETED => 'Complete and Close',
            self::DELAYED => 'Forward for Delay',
            self::REJECTED => 'Reject / Forward',
            self::INVALID_JUSTIFICATION => 'Invalid Justification',
            self::VALID_JUSTIFICATION => 'Valid Justification',
            self::APPEAL_AGAIN => 'Appeal Again to RTS',
        };
    }
}
