<?php

namespace App\Services;

use App\Enums\PointsRuleNameEnum;
use App\Enums\PointsSourceEnum;
use App\Enums\PointsTransactionTypeEnum;
use App\Models\Order;
use App\Models\PointsConfig;
use App\Models\PointsTransaction;
use App\Models\User;

class PointsService
{
    public function awardPurchasePoints(Order $order): void
    {
        $config = $this->getActiveConfig(PointsRuleNameEnum::PURCHASE_RATIO);

        if (!$config) {
            return;
        }

        $points = (int) floor($order->total * $config->rule_value);

        if ($points <= 0) {
            return;
        }

        $this->credit(
            user: $order->user,
            points: $points,
            transactionType: PointsTransactionTypeEnum::PURCHASE,
            source: PointsSourceEnum::ORDER,
            referenceId: $order->id,
            description: "Points earned from order #{$order->id}",
        );
    }

    public function credit(
        User $user,
        int $points,
        PointsTransactionTypeEnum $transactionType,
        ?PointsSourceEnum $source = null,
        ?int $referenceId = null,
        ?string $description = null,
    ): void {
        $user->increment('points', $points);

        PointsTransaction::create([
            'user_id'          => $user->id,
            'points'           => $points,
            'transaction_type' => $transactionType,
            'source'           => $source,
            'reference_id'     => $referenceId,
            'description'      => $description,
        ]);
    }

    private function getActiveConfig(PointsRuleNameEnum $ruleName): ?PointsConfig
    {
        return PointsConfig::where('rule_name', $ruleName)
            ->where('is_active', true)
            ->first();
    }
}
