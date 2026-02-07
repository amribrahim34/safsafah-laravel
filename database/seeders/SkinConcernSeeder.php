<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SkinConcern;

class SkinConcernSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skinConcerns = [
            ['name_ar' => 'حب الشباب', 'name_en' => 'Acne', 'description_ar' => 'مشاكل البثور والحبوب والرؤوس السوداء', 'description_en' => 'Issues with pimples, breakouts and blackheads'],
            ['name_ar' => 'التجاعيد', 'name_en' => 'Wrinkles', 'description_ar' => 'خطوط وتجاعيد البشرة وعلامات التقدم في السن', 'description_en' => 'Fine lines and wrinkles, signs of aging'],
            ['name_ar' => 'البقع الداكنة', 'name_en' => 'Dark Spots', 'description_ar' => 'فرط التصبغ والبقع الداكنة على البشرة', 'description_en' => 'Hyperpigmentation and dark patches on skin'],
            ['name_ar' => 'الجفاف', 'name_en' => 'Dryness', 'description_ar' => 'نقص الرطوبة والشعور بالشد في البشرة', 'description_en' => 'Lack of moisture and tight feeling skin'],
            ['name_ar' => 'المسام الواسعة', 'name_en' => 'Large Pores', 'description_ar' => 'مسام مرئية ومتوسعة على البشرة', 'description_en' => 'Visible and enlarged pores on the skin'],
            ['name_ar' => 'البشرة الباهتة', 'name_en' => 'Dull Skin', 'description_ar' => 'فقدان الإشراق والحيوية في البشرة', 'description_en' => 'Loss of radiance and vitality in the skin'],
            ['name_ar' => 'الاحمرار', 'name_en' => 'Redness', 'description_ar' => 'احمرار والتهاب في البشرة', 'description_en' => 'Redness and inflammation in the skin'],
            ['name_ar' => 'الخطوط الدقيقة', 'name_en' => 'Fine Lines', 'description_ar' => 'خطوط رفيعة حول العينين والفم', 'description_en' => 'Thin lines around eyes and mouth'],
        ];

        foreach ($skinConcerns as $concern) {
            SkinConcern::firstOrCreate(['name_en' => $concern['name_en']], $concern);
        }
    }
}
