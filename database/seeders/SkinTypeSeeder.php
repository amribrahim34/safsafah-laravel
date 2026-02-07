<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkinType;

class SkinTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skinTypes = [
            ['name_ar' => 'بشرة جافة', 'name_en' => 'Dry Skin', 'description_ar' => 'بشرة تفتقر إلى الرطوبة وتحتاج إلى ترطيب مكثف', 'description_en' => 'Skin that lacks moisture and needs intensive hydration'],
            ['name_ar' => 'بشرة دهنية', 'name_en' => 'Oily Skin', 'description_ar' => 'بشرة تنتج الزيوت الزائدة وتحتاج إلى توازن', 'description_en' => 'Skin that produces excess oil and needs balancing'],
            ['name_ar' => 'بشرة مختلطة', 'name_en' => 'Combination Skin', 'description_ar' => 'بشرة تجمع بين المناطق الجافة والدهنية', 'description_en' => 'Skin that combines dry and oily areas'],
            ['name_ar' => 'بشرة عادية', 'name_en' => 'Normal Skin', 'description_ar' => 'بشرة متوازنة لا جافة ولا دهنية', 'description_en' => 'Balanced skin that is neither dry nor oily'],
            ['name_ar' => 'بشرة حساسة', 'name_en' => 'Sensitive Skin', 'description_ar' => 'بشرة تتفاعل بسهولة مع المنتجات والعوامل الخارجية', 'description_en' => 'Skin that reacts easily to products and external factors'],
        ];

        foreach ($skinTypes as $type) {
            SkinType::firstOrCreate(['name_en' => $type['name_en']], $type);
        }
    }
}
