<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case PENDING    = 'PENDING';
    case CONFIRMED  = 'CONFIRMED';
    case PROCESSING = 'PROCESSING';
    case SHIPPED    = 'SHIPPED';
    case COMPLETED  = 'COMPLETED';
    case CANCELED   = 'CANCELED';
    case REFUNDED   = 'REFUNDED';
    case FAILED     = 'FAILED';
    case ON_HOLD    = 'ON_HOLD';

    public function label(): string
    {
        return match($this) {
            self::PENDING    => 'Pending',
            self::CONFIRMED  => 'Confirmed',
            self::PROCESSING => 'Processing',
            self::SHIPPED    => 'Shipped',
            self::COMPLETED  => 'Completed',
            self::CANCELED   => 'Canceled',
            self::REFUNDED   => 'Refunded',
            self::FAILED     => 'Failed',
            self::ON_HOLD    => 'On Hold',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
