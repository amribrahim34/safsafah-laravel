<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PointsConfig;

class PointsConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pointsConfig = [
            ['rule_name' => 'PURCHASE_RATIO', 'rule_value' => 1.0, 'is_active' => true],
            ['rule_name' => 'POINTS_TO_CURRENCY_RATIO', 'rule_value' => 0.10, 'is_active' => true],
            ['rule_name' => 'MIN_POINTS_TO_REDEEM', 'rule_value' => 100, 'is_active' => true],
            ['rule_name' => 'POINTS_EXPIRY_DAYS', 'rule_value' => 365, 'is_active' => true],
            ['rule_name' => 'REVIEW_POINTS', 'rule_value' => 50, 'is_active' => true],
            ['rule_name' => 'REFERRAL_POINTS', 'rule_value' => 100, 'is_active' => true],
            ['rule_name' => 'SIGNUP_BONUS_POINTS', 'rule_value' => 50, 'is_active' => true],
        ];

        foreach ($pointsConfig as $config) {
            PointsConfig::updateOrCreate(
                ['rule_name' => $config['rule_name']],
                $config
            );
        }
    }
}
