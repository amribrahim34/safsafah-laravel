<?php

namespace App\Enums;

enum PointsSourceEnum: string
{
    case ORDER    = 'ORDER';
    case REVIEW   = 'REVIEW';
    case REFERRAL = 'REFERRAL';
    case SIGNUP   = 'SIGNUP';

    public function label(): string
    {
        return match($this) {
            self::ORDER    => 'Order',
            self::REVIEW   => 'Review',
            self::REFERRAL => 'Referral',
            self::SIGNUP   => 'Signup',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
