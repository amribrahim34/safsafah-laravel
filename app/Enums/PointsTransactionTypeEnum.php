<?php

namespace App\Enums;

enum PointsTransactionTypeEnum: string
{
    case PURCHASE    = 'PURCHASE';
    case REVIEW      = 'REVIEW';
    case REFERRAL    = 'REFERRAL';
    case SIGNUP_BONUS = 'SIGNUP_BONUS';
    case REDEMPTION  = 'REDEMPTION';

    public function label(): string
    {
        return match($this) {
            self::PURCHASE    => 'Purchase',
            self::REVIEW      => 'Review',
            self::REFERRAL    => 'Referral',
            self::SIGNUP_BONUS => 'Signup Bonus',
            self::REDEMPTION  => 'Redemption',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
