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
        ];

        foreach ($activeIngredients as $ingredient) {
            ActiveIngredient::firstOrCreate(['name_en' => $ingredient['name_en']], $ingredient);
        }
    }
}
