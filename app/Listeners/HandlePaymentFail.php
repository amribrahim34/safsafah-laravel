<?php

namespace App\Listeners;

use App\Enums\OrderStatusEnum;
use App\Events\PaymentFail;

class HandlePaymentFail
{
    public function handle(PaymentFail $event): void
    {
        $event->payment->order()->update([
            'status' => OrderStatusEnum::FAILED->value,
        ]);
    }
}
