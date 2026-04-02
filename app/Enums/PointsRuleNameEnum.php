<?php

namespace App\Enums;

enum PointsRuleNameEnum: string
{
    case PURCHASE_RATIO          = 'PURCHASE_RATIO';
    case POINTS_TO_CURRENCY_RATIO = 'POINTS_TO_CURRENCY_RATIO';
    case MIN_POINTS_TO_REDEEM    = 'MIN_POINTS_TO_REDEEM';
    case POINTS_EXPIRY_DAYS      = 'POINTS_EXPIRY_DAYS';
    case REVIEW_POINTS           = 'REVIEW_POINTS';
    case REFERRAL_POINTS         = 'REFERRAL_POINTS';
    case SIGNUP_BONUS_POINTS     = 'SIGNUP_BONUS_POINTS';

    public function label(): string
    {
        return match($this) {
            self::PURCHASE_RATIO          => 'Purchase Ratio',
            self::POINTS_TO_CURRENCY_RATIO => 'Points to Currency Ratio',
            self::MIN_POINTS_TO_REDEEM    => 'Minimum Points to Redeem',
            self::POINTS_EXPIRY_DAYS      => 'Points Expiry Days',
            self::REVIEW_POINTS           => 'Review Points',
            self::REFERRAL_POINTS         => 'Referral Points',
            self::SIGNUP_BONUS_POINTS     => 'Signup Bonus Points',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
