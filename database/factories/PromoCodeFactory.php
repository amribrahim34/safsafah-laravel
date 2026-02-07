<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PromoCode>
 */
class PromoCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->bothify('PROMO-###??'),
            'discount' => fake()->randomFloat(2, 5, 50),
            'is_percent' => fake()->boolean(),
            'expiry_date' => fake()->dateTimeBetween('now', '+1 year'),
            'usage_limit' => fake()->numberBetween(10, 100),
            'times_used' => 0,
            'active' => true,
        ];
    }
}
