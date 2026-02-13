<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\ProductFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SkinTypeSeeder::class,
            SkinConcernSeeder::class,
            ActiveIngredientSeeder::class,
            PointsConfigSeeder::class,
            UserSeeder::class,
            AdminSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
