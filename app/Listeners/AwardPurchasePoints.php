<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Services\PointsService;

class AwardPurchasePoints
{
    public function __construct(private readonly PointsService $pointsService) {}

    public function handle(OrderCreated $event): void
    {
        $order = $event->order->loadMissing('user');

        $this->pointsService->awardPurchasePoints($order);
    }
}
