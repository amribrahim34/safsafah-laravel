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
            ['en' => 'Skin1004', 'ar' => 'سكين1004'],
            ['en' => 'Farm Stay', 'ar' => 'فارم ستاي'],
            ['en' => 'Melatime', 'ar' => 'ميلاتايم'],
            ['en' => 'Medicube', 'ar' => 'ميديكيوب'],
            ['en' => 'Estee Lauder', 'ar' => 'إستي لودر'],
            ['en' => 'L\'Oréal', 'ar' => 'لوريال'],
            ['en' => 'Olaplex', 'ar' => 'أولابليكس'],
            ['en' => 'AXIS-Y', 'ar' => 'أكسيس-واي'],
            ['en' => 'Kiko', 'ar' => 'كيكو'],
            ['en' => 'Maybelline', 'ar' => 'ميبيلين'],
            ['en' => 'La Roche-Posay', 'ar' => 'لاروش بوزيه'],
        ];

        foreach ($brands as $brand) {
            Brand::factory()->create([
                'name_en' => $brand['en'],
                'name_ar' => $brand['ar'],
            ]);
        }
    }
}
