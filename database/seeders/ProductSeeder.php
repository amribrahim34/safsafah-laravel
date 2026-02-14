<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['name_ar' => 'كريم تفتيح دير', 'name_en' => 'Dear Brightening Cream', 'brand' => 'Drakon', 'category' => 'Brightening', 'price' => 420],
            ['name_ar' => 'عطر دون', 'name_en' => 'Don Perfume', 'brand' => 'Leylak', 'category' => 'Body Wash', 'price' => 385],
            ['name_ar' => 'سيروم كوزركس', 'name_en' => 'COSRX Serum', 'brand' => 'Cosrx', 'category' => 'Soothing', 'price' => 1491],
            ['name_ar' => 'سيروم سنتيلا', 'name_en' => 'Centella Serum', 'brand' => 'Skin1004', 'category' => 'Soothing', 'price' => 1603],
            ['name_ar' => 'واقي شمس فارم', 'name_en' => 'Farm Sun Block', 'brand' => 'Farm Stay', 'category' => 'Face Sunscreen', 'price' => 693],
            ['name_ar' => 'مجموعة المعجزة', 'name_en' => 'Miracle Set', 'brand' => 'Some By Mi', 'category' => 'Anti-Acne', 'price' => 1386],
            ['name_ar' => 'سيروم نياسيناميد 10+', 'name_en' => 'Niacinamide 10+ Serum', 'brand' => 'The Ordinary', 'category' => 'Brightening', 'price' => 1701],
            ['name_ar' => 'فارم ستاي الصبار', 'name_en' => 'Farm Stay Aloe Vera', 'brand' => 'Farm Stay', 'category' => 'Soothing', 'price' => 637],
            ['name_ar' => 'واقي شمس بخاخ ميلاتايم', 'name_en' => 'Melatime Sun Screen Spray', 'brand' => 'Melatime', 'category' => 'Body Sunscreen', 'price' => 574],
            ['name_ar' => 'كريم جل واقي شمس ميلاتايم', 'name_en' => 'Melatime Sun Screen Cream Gel', 'brand' => 'Melatime', 'category' => 'Face Sunscreen', 'price' => 539],
            ['name_ar' => 'جل واقي شمس وبرايمر ميلاتايم', 'name_en' => 'Melatime Sun Screen Gel Primer', 'brand' => 'Melatime', 'category' => 'Face Sunscreen', 'price' => 609],
            ['name_ar' => 'كريم العين ريفايف من بيوتي أوف جوسون', 'name_en' => 'Beauty of Joseon Revive Eye Cream', 'brand' => 'Beauty of Joseon', 'category' => 'Anti-Aging', 'price' => 1337],
            ['name_ar' => 'تونر أحماض التقشير المعجزة من سوم باي مي', 'name_en' => 'Some By Mi AHA BHA Miracle Toner', 'brand' => 'Some By Mi', 'category' => 'Anti-Acne', 'price' => 1211],
            ['name_ar' => 'سيروم يوجا نياسين من سوم باي مي', 'name_en' => 'Some By Mi Yuja Niacin Serum', 'brand' => 'Some By Mi', 'category' => 'Brightening', 'price' => 1365],
            ['name_ar' => 'مجموعة ريتينول آي كريم وسيروم من سوم باي مي', 'name_en' => 'Some By Mi Retinol Eye Cream & Serum Set', 'brand' => 'Some By Mi', 'category' => 'Anti-Aging', 'price' => 1393],
            ['name_ar' => 'سيروم العسل من بيوتي أوف جوسون', 'name_en' => 'Beauty of Joseon Propolis Serum', 'brand' => 'Beauty of Joseon', 'category' => 'Brightening', 'price' => 1281],
            ['name_ar' => 'سيروم الشاي الأخضر من بيوتي أوف جوسون', 'name_en' => 'Beauty of Joseon Green Tea Serum', 'brand' => 'Beauty of Joseon', 'category' => 'Soothing', 'price' => 1281],
            ['name_ar' => 'زيت مهابرينج', 'name_en' => 'Mahabhringraj Oil', 'brand' => 'Infinity', 'category' => 'Treatments', 'price' => 434],
            ['name_ar' => 'بلسم روزي بيكيني', 'name_en' => 'Rozy Bikini Balm', 'brand' => 'Infinity', 'category' => 'Body Wash', 'price' => 559],
            ['name_ar' => 'كريم ديب في سي من ميديكيوب', 'name_en' => 'Medicube Deep V C Cream', 'brand' => 'Medicube', 'category' => 'Brightening', 'price' => 1578],
            ['name_ar' => 'واقي شمس ميديكيوب 50%', 'name_en' => 'Medicube Sunscreen 50%', 'brand' => 'Medicube', 'category' => 'Face Sunscreen', 'price' => 1398],
            ['name_ar' => 'تونر سنتيلا 74%', 'name_en' => 'Centella 74% Toner', 'brand' => 'Skin1004', 'category' => 'Soothing', 'price' => 1038],
            ['name_ar' => 'غسول زيتي ديربو سيكا', 'name_en' => 'Derbu Sica Cleansing Oil', 'brand' => 'Cosrx', 'category' => 'Cleansing', 'price' => 918],
            ['name_ar' => 'كريم كبسولات تيكسا نياسيناميد 5% من ميديكيوب', 'name_en' => 'Medicube TXA Niacinamide Capsule Cream 5%', 'brand' => 'Medicube', 'category' => 'Brightening', 'price' => 1518],
            ['name_ar' => 'سيروم الببتيدات الستة للترميم من كوزركس', 'name_en' => 'COSRX 6 Peptide Skin Booster Serum', 'brand' => 'Cosrx', 'category' => 'Anti-Aging', 'price' => 1278],
            ['name_ar' => 'كريم العين بالببتيد والحلزون من كوزركس', 'name_en' => 'COSRX Peptide Snail Eye Cream', 'brand' => 'Cosrx', 'category' => 'Anti-Aging', 'price' => 798],
            ['name_ar' => 'سيروم النياسيناميد 15 من كوزركس', 'name_en' => 'COSRX Niacinamide 15 Serum', 'brand' => 'Cosrx', 'category' => 'Anti-Acne', 'price' => 798],
            ['name_ar' => 'سيروم حمض الهيالورونيك 3 من كوزركس', 'name_en' => 'COSRX Hyaluronic Acid 3 Serum', 'brand' => 'Cosrx', 'category' => 'Hydration', 'price' => 798],
            ['name_ar' => 'زيت الريتينول 0.5 من كوزركس', 'name_en' => 'COSRX Retinol 0.5 Oil', 'brand' => 'Cosrx', 'category' => 'Anti-Aging', 'price' => 798],
            ['name_ar' => 'واقي شمس ستيك من بيوتي أوف جوسون', 'name_en' => 'Beauty of Joseon Sun Stick', 'brand' => 'Beauty of Joseon', 'category' => 'Face Sunscreen', 'price' => 978],
            ['name_ar' => 'زيت التنظيف بالجينسينج من بيوتي أوف جوسون', 'name_en' => 'Beauty of Joseon Ginseng Cleansing Oil', 'brand' => 'Beauty of Joseon', 'category' => 'Cleansing', 'price' => 1278],
            ['name_ar' => 'قناع الإشراقة بالأرز والعسل من بيوتي أوف جوسون', 'name_en' => 'Beauty of Joseon Rice and Honey Glow Mask', 'brand' => 'Beauty of Joseon', 'category' => 'Brightening', 'price' => 978],
            ['name_ar' => 'جل منظف ليلي من إستي لودر', 'name_en' => 'Estee Lauder Night Cleansing Gel', 'brand' => 'Estee Lauder', 'category' => 'Cleansing', 'price' => 978],
            ['name_ar' => 'غسول الجسم العلاجي من سوم باي مي', 'name_en' => 'Some By Mi Acne Clear Body Cleanser', 'brand' => 'Some By Mi', 'category' => 'Body Wash', 'price' => 1158],
            ['name_ar' => 'تونر بيتا بانثينول 150 مل من سوم باي مي', 'name_en' => 'Some By Mi Beta Panthenol Toner 150ml', 'brand' => 'Some By Mi', 'category' => 'Barrier Repair', 'price' => 918],
            ['name_ar' => 'كريم المعجزة AHA BHA من سوم باي مي', 'name_en' => 'Some By Mi Miracle Cream AHA BHA', 'brand' => 'Some By Mi', 'category' => 'Anti-Acne', 'price' => 918],
            ['name_ar' => 'كريم إصلاح بيتا بانثينول من سوم باي مي', 'name_en' => 'Some By Mi Beta Panthenol Repair Cream', 'brand' => 'Some By Mi', 'category' => 'Barrier Repair', 'price' => 918],
            ['name_ar' => 'مجموعة الحلزون الأسود من سوم باي مي', 'name_en' => 'Some By Mi Black Snail Set', 'brand' => 'Some By Mi', 'category' => 'Barrier Repair', 'price' => 1398],
            ['name_ar' => 'مجموعة B5 من سوم باي مي', 'name_en' => 'Some By Mi B5 Set', 'brand' => 'Some By Mi', 'category' => 'Hydration', 'price' => 1398],
            ['name_ar' => 'تونيك للشعر من سوم باي مي', 'name_en' => 'Some By Mi Hair Tonic', 'brand' => 'Some By Mi', 'category' => 'Treatments', 'price' => 918],
            ['name_ar' => 'مقشر الشفاه بالعسل والسكر من كوزركس', 'name_en' => 'COSRX Honey Sugar Lip Scrub', 'brand' => 'Cosrx', 'category' => 'Scrubs', 'price' => 666],
            ['name_ar' => 'ماسك ليلي للشفاه من كوزركس', 'name_en' => 'COSRX Lip Sleep Mask', 'brand' => 'Cosrx', 'category' => 'Hydration', 'price' => 666],
            ['name_ar' => 'ماسك الشفاه بالسيراميد من كوزركس', 'name_en' => 'COSRX Ceramide Lip Butter Mask', 'brand' => 'Cosrx', 'category' => 'Hydration', 'price' => 666],
            ['name_ar' => 'كريم الحلزون المتطور 92 من كوزركس', 'name_en' => 'COSRX Advanced Snail 92 All in One Cream', 'brand' => 'Cosrx', 'category' => 'Hydration', 'price' => 1038],
            ['name_ar' => 'الإيسنس الحلزوني المزدوج من كوزركس', 'name_en' => 'COSRX Advanced Snail Radiance Dual Essence', 'brand' => 'Cosrx', 'category' => 'Brightening', 'price' => 1158],
            ['name_ar' => 'تونر يوجا نياسين من سوم باي مي', 'name_en' => 'Some By Mi Yuja Niacin Toner', 'brand' => 'Some By Mi', 'category' => 'Brightening', 'price' => 978],
            ['name_ar' => 'مقشر كيميائي لطيف BHA 4% من كوزركس', 'name_en' => 'COSRX BHA 4% Blackhead Power Liquid', 'brand' => 'Cosrx', 'category' => 'Anti-Acne', 'price' => 798],
            ['name_ar' => 'إيسنس تفتيح 95% من كوزركس', 'name_en' => 'COSRX Galactomyces 95 Tone Balancing Essence', 'brand' => 'Cosrx', 'category' => 'Brightening', 'price' => 798],
            ['name_ar' => 'مجموعة الحلزون من كوزركس', 'name_en' => 'COSRX Snail Set', 'brand' => 'Cosrx', 'category' => 'Barrier Repair', 'price' => 1158],
            ['name_ar' => 'ماسك لوريال بروفيشنال أبسولوت', 'name_en' => 'L\'Oréal Professionnel Absolut Repair Mask', 'brand' => 'L\'Oréal', 'category' => 'Treatments', 'price' => 1938],
            ['name_ar' => 'زيت أبسولوت ريبير للشعر من لوريال', 'name_en' => 'L\'Oréal Absolut Repair Oil', 'brand' => 'L\'Oréal', 'category' => 'Treatments', 'price' => 1386],
            ['name_ar' => 'ماسك لوريال بروفيشنال أبسولوت ريبير بالبروتين والكينوا', 'name_en' => 'L\'Oréal Absolut Repair Mask with Protein and Gold Quinoa', 'brand' => 'L\'Oréal', 'category' => 'Treatments', 'price' => 1302],
            ['name_ar' => 'بلسم لوريال بروفيشنال أبسولوت ريبير', 'name_en' => 'L\'Oréal Absolut Repair Conditioner', 'brand' => 'L\'Oréal', 'category' => 'Conditioner', 'price' => 1098],
            ['name_ar' => 'منظف رغوي من سوم باي مي', 'name_en' => 'Some By Mi Foam Cleanser', 'brand' => 'Some By Mi', 'category' => 'Cleansing', 'price' => 978],
            ['name_ar' => 'قناع النوم المضيء يوجا نياسين', 'name_en' => 'Yuja Niacin Brightening Sleeping Mask', 'brand' => 'Some By Mi', 'category' => 'Brightening', 'price' => 978],
            ['name_ar' => 'كريم الريتينول 0.1 من كوزركس', 'name_en' => 'COSRX The Retinol 0.1 Cream', 'brand' => 'Cosrx', 'category' => 'Anti-Aging', 'price' => 798],
            ['name_ar' => 'كريم العيون الغني من بيوتي أوف جوسون', 'name_en' => 'Beauty of Joseon Revive Eye Serum', 'brand' => 'Beauty of Joseon', 'category' => 'Anti-Aging', 'price' => 918],
            ['name_ar' => 'كريم الحماية من الشمس هارت ليف من أنوا', 'name_en' => 'Anua Heartleaf Sun Cream', 'brand' => 'Anua', 'category' => 'Face Sunscreen', 'price' => 858],
            ['name_ar' => 'واقي شمس ريليف صن بالأرز والبروبيوتيك', 'name_en' => 'Relief Sun: Rice + Probiotics SPF50+', 'brand' => 'Beauty of Joseon', 'category' => 'Face Sunscreen', 'price' => 1098],
            ['name_ar' => 'غسول رغوي مرطب بحمض الهيالورونيك والبانثينول', 'name_en' => 'Hydrating Foam Cleanser with Hyaluronic Acid + Panthenol', 'brand' => 'Infinity', 'category' => 'Cleansing', 'price' => 1158],
            ['name_ar' => 'كريم تفتيح البشرة الخوخ 77% نياسيناميد من أنوا', 'name_en' => 'Anua Peach 77% Niacinamide Enriched Cream', 'brand' => 'Anua', 'category' => 'Brightening', 'price' => 918],
            ['name_ar' => 'تونر الحليب المغذي من أنوا', 'name_en' => 'Anua Rich Milk Toner', 'brand' => 'Anua', 'category' => 'Hydration', 'price' => 978],
            ['name_ar' => 'لوشن هارت ليف 70% للتهدئة اليومية من أنوا', 'name_en' => 'Anua Heartleaf 70% Daily Relief Lotion', 'brand' => 'Anua', 'category' => 'Soothing', 'price' => 978],
            ['name_ar' => 'أمبولة هارت ليف 80% المهدئة من أنوا', 'name_en' => 'Anua Heartleaf 80% Soothing Ampoule', 'brand' => 'Anua', 'category' => 'Soothing', 'price' => 978],
            ['name_ar' => 'بلسم أولابليكس رقم 5 لصيانة الروابط', 'name_en' => 'Olaplex No. 5 Bond Maintenance Conditioner', 'brand' => 'Olaplex', 'category' => 'Conditioner', 'price' => 798],
            ['name_ar' => 'شامبو أولابليكس رقم 4 لصيانة الروابط', 'name_en' => 'Olaplex No. 4 Bond Maintenance Shampoo', 'brand' => 'Olaplex', 'category' => 'Shampoo', 'price' => 798],
            ['name_ar' => 'زيت أولابليكس رقم 7 للروابط', 'name_en' => 'Olaplex No. 7 Bonding Oil', 'brand' => 'Olaplex', 'category' => 'Treatments', 'price' => 858],
            ['name_ar' => 'سيروم بروبيوتيك مركز', 'name_en' => 'Concentrated Probiotic Serum', 'brand' => 'Infinity', 'category' => 'Barrier Repair', 'price' => 858],
            ['name_ar' => 'السيروم الكلاسيكي لتهدئة وتجديد البشرة الحساسة', 'name_en' => 'Classic Calming & Regenerating Serum', 'brand' => 'Infinity', 'category' => 'Soothing', 'price' => 858],
            ['name_ar' => 'أمبولة شاي-تريكا المهدئة من سكين1004', 'name_en' => 'Skin1004 Madagascar Centella Tea-Trica Relief Ampoule', 'brand' => 'Skin1004', 'category' => 'Soothing', 'price' => 858],
            ['name_ar' => 'أمبولة مادغشقر سنتيلا المنعشة من سكين1004', 'name_en' => 'Skin1004 Madagascar Centella Fresh Ampoule', 'brand' => 'Skin1004', 'category' => 'Soothing', 'price' => 858],
            ['name_ar' => 'ماسك ليس أنليميتد من لوريال بروفيشنال', 'name_en' => 'L\'Oréal Professionnel Liss Unlimited Mask', 'brand' => 'L\'Oréal', 'category' => 'Treatments', 'price' => 1302],
            ['name_ar' => 'شامبو ليس أنليميتد من لوريال بروفيشنال', 'name_en' => 'L\'Oréal Professionnel Liss Unlimited Shampoo', 'brand' => 'L\'Oréal', 'category' => 'Shampoo', 'price' => 1938],
            ['name_ar' => 'مجموعة يوجا نياسين ضد العيوب من سوم باي مي', 'name_en' => 'Some By Mi Yuja Niacin Anti Blemish Set', 'brand' => 'Some By Mi', 'category' => 'Anti-Acne', 'price' => 978],
            ['name_ar' => 'غسول يومي لطيف بحمض الساليسيليك من كوزركس', 'name_en' => 'COSRX Salicylic Acid Daily Gentle Cleanser', 'brand' => 'Cosrx', 'category' => 'Cleansing', 'price' => 858],
            ['name_ar' => 'لصقات حب الشباب المتقدمة من كوزركس', 'name_en' => 'COSRX Acne Pimple Master Patch', 'brand' => 'Cosrx', 'category' => 'Anti-Acne', 'price' => 294],
            ['name_ar' => 'سيروم الكولاجين النباتي للعين', 'name_en' => 'Vegan Collagen Eye Serum', 'brand' => 'Infinity', 'category' => 'Anti-Aging', 'price' => 1158],
            ['name_ar' => 'كريم تصحيح البقع الداكنة وتفتيح البشرة', 'name_en' => 'Dark Spot Correcting & Brightening Cream', 'brand' => 'Infinity', 'category' => 'Brightening', 'price' => 1158],
            ['name_ar' => 'سبوت ذا ديفرنس من أكسيس-واي', 'name_en' => 'AXIS-Y Spot The Difference Blemish Treatment', 'brand' => 'AXIS-Y', 'category' => 'Anti-Acne', 'price' => 582],
            ['name_ar' => 'سيروم البقع الداكنة', 'name_en' => 'Dark Spot Serum', 'brand' => 'Infinity', 'category' => 'Brightening', 'price' => 1098],
            ['name_ar' => 'أمبولة الخرشوف المكثفة من أكسيس-واي', 'name_en' => 'AXIS-Y Artichoke Intensive Skin Barrier Ampoule', 'brand' => 'AXIS-Y', 'category' => 'Barrier Repair', 'price' => 858],
            ['name_ar' => 'كيكو دبل تاتش 103', 'name_en' => 'Kiko Double Touch 103', 'brand' => 'Kiko', 'category' => 'Styling', 'price' => 870],
            ['name_ar' => 'ماسكارا سكاي هاي من ميبيلين', 'name_en' => 'Maybelline Sky High Mascara', 'brand' => 'Maybelline', 'category' => 'Styling', 'price' => 630],
            ['name_ar' => 'واقي شمس من لاروش بوزيه', 'name_en' => 'La Roche-Posay Sunscreen', 'brand' => 'La Roche-Posay', 'category' => 'Face Sunscreen', 'price' => 522],
            ['name_ar' => 'كريم للعين', 'name_en' => 'Eye Cream', 'brand' => 'Infinity', 'category' => 'Anti-Aging', 'price' => 1248],
        ];

        foreach ($products as $productData) {
            // Find Brand by name (must exist in BrandSeeder)
            $brand = Brand::where('name_en', $productData['brand'])->first();

            // Find Category (Subcategory) by name (must exist in CategorySeeder)
            $category = Category::where('name_en', $productData['category'])->first();

            // Fallback to random if not found (shouldn't happen if seeders are correct)
            $brandId = $brand?->id ?? Brand::inRandomOrder()->first()?->id;
            $categoryId = $category?->id ?? Category::inRandomOrder()->first()?->id;

            Product::factory()->create([
                'name_ar' => $productData['name_ar'],
                'name_en' => $productData['name_en'],
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'price' => $productData['price'],
            ]);
        }
    }
}
