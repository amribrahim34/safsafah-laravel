<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['en' => 'Drakon', 'ar' => 'دراكون'],
            ['en' => 'Leylak', 'ar' => 'ليلاك'],
            ['en' => 'Some By Mi', 'ar' => 'سام باي مي'],
            ['en' => 'Cosrx', 'ar' => 'كوسركس'],
            ['en' => 'Bioderma', 'ar' => 'بيوديرما'],
            ['en' => 'Cetaphil', 'ar' => 'سيتافيل'],
            ['en' => 'Anua', 'ar' => 'أنوا'],
            ['en' => 'The Ordinary', 'ar' => 'ذا أورديناري'],
            ['en' => 'Beauty of Joseon', 'ar' => 'بيوتي أوف جوسون'],
            ['en' => 'Infinity', 'ar' => 'إنفينيتي'],
        ];

        foreach ($brands as $brand) {
            Brand::factory()->create([
                'name_en' => $brand['en'],
                'name_ar' => $brand['ar'],
            ]);
        }
    }
}
