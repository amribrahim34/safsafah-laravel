<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use function Pest\Laravel\getJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can fetch home data', function () {
    Product::factory()->count(5)->create();
    Category::factory()->count(3)->create();
    Brand::factory()->count(3)->create();

    $response = getJson('/api/home');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'sliders',
                'categories',
                'brands',
                'featuredProducts',
                'newArrivals',
            ]
        ]);
});

test('can fetch brands home data', function () {
    $brand = Brand::factory()->create([
        'name_ar' => 'كوزركس',
        'name_en' => 'cosrux 1',
        'logo' => 'uploads/4418e83b-10fd-4875-945d-831000468eef.png'
    ]);
    $response = getJson('/api/home/brands');
    $response->assertOk()
        ->assertJson([
            'data' => [
                [
                    'id' => $brand->id,
                    'nameAr' => 'كوزركس',
                    'nameEn' => 'cosrux 1',
                    'logo' =>  $brand->logo_url
                ]
            ]
        ]);
});


test('can fetch  home new-arrival-products data', function () {
    [$product, $brand, $category] = createProductWithRelations();
    $response = getJson('/api/home/new-arrival-products');

    $response->assertOk()
        ->assertJson([
            'data' => [
                getExpectedProductJson($product, $brand, $category)
            ]
        ]);
});


test('can fetch  home best-seller-products data', function () {
    [$product, $brand, $category] = createProductWithRelations();
    $response = getJson('/api/home/best-seller-products');

    $response->assertOk()
        ->assertJson([
            'data' => [
                getExpectedProductJson($product, $brand, $category)
            ]
        ]);
});



test('can fetch categories home data', function () {
    $category = Category::factory()->create([
        'name_ar' => 'العناية بالبشرة',
        'name_en' => 'skin care',
        'image' => 'uploads/4418e83b-10fd-4875-945d-831000468eef.png',
    ]);
    $response = getJson('/api/home/categories');
    $response->assertOk()
        ->assertJson([
            'data' => [
                [
                    'id' => $category->id,
                    'nameAr' => 'العناية بالبشرة',
                    'nameEn' => 'skin care',
                    'image'=> $category->image_url,
                ]
            ]
        ]);
});

function createProductWithRelations()
{
    $brand = Brand::factory()->create();
    $category = Category::factory()->create();
    $product = Product::factory()->create([
        'name_ar' => 'كوزركس',
        'name_en' => 'cosrux 1',
        'brand_id' => $brand->id,
        'category_id' => $category->id,
        'description_ar' => 'وصف المنتج',
        'description_en' => 'product description',
        'price' => 100,
        'image' => 'uploads/4418e83b-10fd-4875-945d-831000468eef.png'
    ]);
    return [$product, $brand, $category];
}

function getExpectedProductJson($product, $brand, $category)
{
    return [
        'id' => $product->id,
        'nameAr' => 'كوزركس',
        'nameEn' => 'cosrux 1',
        'image' =>  $product->image_url,
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
