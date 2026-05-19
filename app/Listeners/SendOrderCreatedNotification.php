<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderCreatedMail;
use Illuminate\Support\Facades\Mail;

class SendOrderCreatedNotification
{
    public function handle(OrderCreated $event): void
    {
        Mail::to('safsafah035@gmail.com')->send(new OrderCreatedMail($event->order));
    }
}
