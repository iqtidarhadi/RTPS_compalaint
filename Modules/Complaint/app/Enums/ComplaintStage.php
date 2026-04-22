<?php

namespace Modules\Complaint\Enums;

enum ComplaintStage: string
{
    case CITIZEN = 'citizen';
    case SPO = 'spo';
    case APPELLATE_AUTHORITY = 'appellate_authority';
    case RTS_COMMISSION = 'rts_commission';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::CITIZEN => 'Citizen',
            self::SPO => 'Service Point Officer',
            self::APPELLATE_AUTHORITY => 'Appellate Authority',
            self::RTS_COMMISSION => 'RTS Commission',
            self::CLOSED => 'Closed',
        };
    }
}
