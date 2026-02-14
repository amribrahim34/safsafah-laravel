<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActiveIngredient;

class ActiveIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activeIngredients = [
            ['name_ar' => 'حمض الهيالورونيك', 'name_en' => 'Hyaluronic Acid'],
            ['name_ar' => 'فيتامين سي', 'name_en' => 'Vitamin C'],
            ['name_ar' => 'الريتينول', 'name_en' => 'Retinol'],
            ['name_ar' => 'النياسيناميد', 'name_en' => 'Niacinamide'],
            ['name_ar' => 'حمض الساليسيليك', 'name_en' => 'Salicylic Acid'],
            ['name_ar' => 'حمض الجليكوليك', 'name_en' => 'Glycolic Acid'],
            ['name_ar' => 'الببتيدات', 'name_en' => 'Peptides'],
            ['name_ar' => 'السيراميد', 'name_en' => 'Ceramides'],
            ['name_ar' => 'فيتامين إي', 'name_en' => 'Vitamin E'],
            ['name_ar' => 'حمض اللاكتيك', 'name_en' => 'Lactic Acid'],
            ['name_ar' => 'الكافيين', 'name_en' => 'Caffeine'],
            ['name_ar' => 'البانثينول', 'name_en' => 'Panthenol'],
            ['name_ar' => 'حمض الأزيليك', 'name_en' => 'Azelaic Acid'],
            ['name_ar' => 'الكولاجين', 'name_en' => 'Collagen'],
            ['name_ar' => 'الألوفيرا', 'name_en' => 'Aloe Vera'],
            ['name_ar' => 'سنتيلا أسياتيكا', 'name_en' => 'Centella Asiatica'],
            ['name_ar' => 'بروبوليس', 'name_en' => 'Propolis'],
            ['name_ar' => 'أحماض AHA', 'name_en' => 'AHA'],
            ['name_ar' => 'أحماض BHA', 'name_en' => 'BHA'],
            ['name_ar' => 'أحماض PHA', 'name_en' => 'PHA'],
            ['name_ar' => 'حمض الترانيكساميك', 'name_en' => 'Tranexamic Acid'],
            ['name_ar' => 'الشاي الأخضر', 'name_en' => 'Green Tea'],
            ['name_ar' => 'الجينسينغ', 'name_en' => 'Ginseng'],
            ['name_ar' => 'خلاصة الأرز', 'name_en' => 'Rice Extract'],
            ['name_ar' => 'الحلزون', 'name_en' => 'Snail Mucin'],
            ['name_ar' => 'أربيوتن', 'name_en' => 'Arbutin'],
            ['name_ar' => 'جلوتاثيون', 'name_en' => 'Glutathione'],
            ['name_ar' => 'عرقسوس', 'name_en' => 'Licorice'],
            ['name_ar' => 'كركم', 'name_en' => 'Turmeric'],
        ];

        foreach ($activeIngredients as $ingredient) {
            ActiveIngredient::firstOrCreate(['name_en' => $ingredient['name_en']], $ingredient);
        }
    }
}
