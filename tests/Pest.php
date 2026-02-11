<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
 // ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Create a product with related brand and category for testing
 */
function createProductWithRelations(
    array $productData = [],
    bool $useNullCategory = false,
    bool $useNullBrand = false
): array {
    $brand = $useNullBrand ? null : \App\Models\Brand::factory()->create();
    $category = $useNullCategory ? null : \App\Models\Category::factory()->create();

    $defaults = [
        'brand_id' => $brand?->id,
        'category_id' => $category?->id,
    ];

    $product = \App\Models\Product::factory()->create(array_merge($defaults, $productData));

    return [$product, $brand, $category];
}

/**
 * Get expected product JSON structure for assertions
 */
function getExpectedProductJson($product, $brand, $category): array
{
    return [
        'id' => $product->id,
        'nameAr' => $product->name_ar,
        'nameEn' => $product->name_en,
        'image' => $product->image_url,
        'price' => $product->price,
        'brand' => [
            'name_ar' => $brand->name_ar,
            'name_en' => $brand->name_en,
        ],
        'category' => [
            'name_ar' => $category->name_ar,
            'name_en' => $category->name_en,
        ],
        'rating' => $product->rating,
        'ratingCount' => $product->rating_count
    ];
}
