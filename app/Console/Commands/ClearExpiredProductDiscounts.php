<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ClearExpiredProductDiscounts extends Command
{
    protected $signature = 'products:clear-expired-discounts';

    protected $description = 'Clear discount fields on products whose discount period has ended';

    public function handle(): int
    {
        $count = Product::query()
            ->whereNotNull('discount')
            ->where('discount_ends_at', '<', now())
            ->update([
                'discount'           => null,
                'discount_starts_at' => null,
                'discount_ends_at'   => null,
            ]);

        $this->info("Cleared expired discounts from {$count} product(s).");

        return self::SUCCESS;
    }
}
