<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'en' => 'Skincare', 'ar' => 'العناية بالبشرة',
                'children' => [
                    ['en' => 'Cleansing', 'ar' => 'تنظيف'],
                    ['en' => 'Barrier Repair', 'ar' => 'ترميم حاجز البشرة'],
                    ['en' => 'Hydration', 'ar' => 'ترطيب'],
                    ['en' => 'Anti-Aging', 'ar' => 'مكافحة الشيخوخة'],
                    ['en' => 'Brightening', 'ar' => 'تفتيح'],
                    ['en' => 'Soothing', 'ar' => 'تهدئة'],
                    ['en' => 'Anti-Acne', 'ar' => 'مكافحة حب الشباب'],
                ]
            ],
            [
                'en' => 'Haircare', 'ar' => 'العناية بالشعر',
                'children' => [
                    ['en' => 'Shampoo', 'ar' => 'شامبو'],
                    ['en' => 'Conditioner', 'ar' => 'بلسم'],
                    ['en' => 'Treatments', 'ar' => 'علاجات'],
                    ['en' => 'Styling', 'ar' => 'تصفيف'],
                ]
            ],
            [
                'en' => 'Bodycare', 'ar' => 'العناية بالجسم',
                'children' => [
                    ['en' => 'Body Wash', 'ar' => 'غسول الجسم'],
                    ['en' => 'Moisturizers', 'ar' => 'مرطبات'],
                    ['en' => 'Scrubs', 'ar' => 'مقشرات'],
                ]
            ],
            [
                'en' => 'Sun Protection', 'ar' => 'الحماية من الشمس',
                'children' => [
                    ['en' => 'Face Sunscreen', 'ar' => 'واقي شمس للوجه'],
                    ['en' => 'Body Sunscreen', 'ar' => 'واقي شمس للجسم'],
                    ['en' => 'After Sun', 'ar' => 'بعد التعرض للشمس'],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $parent = Category::create([
                'name_en' => $categoryData['en'],
                'name_ar' => $categoryData['ar'],
                'image' => Category::factory()->make()->image, // Use factory for random image
            ]);

            if (isset($categoryData['children'])) {
                foreach ($categoryData['children'] as $childData) {
                    Category::create([
                        'name_en' => $childData['en'],
                        'name_ar' => $childData['ar'],
                        'parent_id' => $parent->id,
                        'image' => Category::factory()->make()->image,
                    ]);
                }
            }
        }
    }
}
