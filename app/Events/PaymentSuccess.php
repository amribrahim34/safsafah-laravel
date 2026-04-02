<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;

class PaymentSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Payment $payment)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('orders.' . $this->payment->order_id),
        ];
    }
}
