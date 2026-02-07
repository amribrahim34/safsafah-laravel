<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total' => $this->faker->randomFloat(2, 50, 500),
            'subtotal' => $this->faker->randomFloat(2, 40, 450),
            'tax' => $this->faker->randomFloat(2, 5, 50),
            'shipping' => $this->faker->randomFloat(2, 0, 20),
            'discount' => 0,
            'status' => 'PENDING',
            'promo_code_id' => null,
            'address_id' => Address::factory(),
        ];
    }
}
