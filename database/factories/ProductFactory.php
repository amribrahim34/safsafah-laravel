<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fakerAr = \Faker\Factory::create('ar_SA');

        return [
            'name_ar' => $fakerAr->realText(50),
            'name_en' => $this->faker->words(3, true),
            'description_ar' => $fakerAr->realText(200),
            'description_en' => $this->faker->paragraph(),
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'image' => $this->faker->imageUrl(),
            'sku' => $this->faker->unique()->ean13(),
        ];
    }
}
