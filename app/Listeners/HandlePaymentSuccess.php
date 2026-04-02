<?php

namespace App\Listeners;

use App\Enums\OrderStatusEnum;
use App\Events\PaymentSuccess;

class HandlePaymentSuccess
{
    public function handle(PaymentSuccess $event): void
    {
        $event->payment->order()->update([
            'status' => OrderStatusEnum::CONFIRMED->value,
        ]);
    }
}
