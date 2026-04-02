<?php

namespace Database\Seeders;

use App\Enums\PointsRuleNameEnum;
use App\Models\PointsConfig;
use Illuminate\Database\Seeder;

class PointsConfigSeeder extends Seeder
{
    public function run(): void
    {
        $pointsConfig = [
            ['rule_name' => PointsRuleNameEnum::PURCHASE_RATIO->value,          'rule_value' => 1.0,  'is_active' => true],
            ['rule_name' => PointsRuleNameEnum::POINTS_TO_CURRENCY_RATIO->value, 'rule_value' => 0.10, 'is_active' => true],
            ['rule_name' => PointsRuleNameEnum::MIN_POINTS_TO_REDEEM->value,    'rule_value' => 100,  'is_active' => true],
            ['rule_name' => PointsRuleNameEnum::POINTS_EXPIRY_DAYS->value,      'rule_value' => 365,  'is_active' => true],
            ['rule_name' => PointsRuleNameEnum::REVIEW_POINTS->value,           'rule_value' => 50,   'is_active' => true],
            ['rule_name' => PointsRuleNameEnum::REFERRAL_POINTS->value,         'rule_value' => 100,  'is_active' => true],
            ['rule_name' => PointsRuleNameEnum::SIGNUP_BONUS_POINTS->value,     'rule_value' => 50,   'is_active' => true],
        ];

        foreach ($pointsConfig as $config) {
            PointsConfig::updateOrCreate(
                ['rule_name' => $config['rule_name']],
                $config
            );
        }
    }
}
