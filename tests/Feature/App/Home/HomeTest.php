<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

test('can fetch brands home data', function () {
    $brand = Brand::factory()->create([
        'name_ar' => 'كوزركس',
        'name_en' => 'cosrux 1',
        'logo' => 'uploads/4418e83b-10fd-4875-945d-831000468eef.png'
    ]);
    $response = getJson('/api/app/home/brands');
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
    [$product, $brand, $category] = createProductWithRelations([
        'name_ar' => 'كوزركس',
        'name_en' => 'cosrux 1',
        'description_ar' => 'وصف المنتج',
        'description_en' => 'product description',
        'price' => 100,
        'image' => 'uploads/4418e83b-10fd-4875-945d-831000468eef.png'
    ]);
    $response = getJson('/api/app/home/new-arrival-products');

    $response->assertOk()
        ->assertJson([
            'data' => [
                getExpectedProductJson($product, $brand, $category)
            ]
        ]);
});


test('can fetch  home best-seller-products data', function () {
    [$product, $brand, $category] = createProductWithRelations([
        'name_ar' => 'كوزركس',
        'name_en' => 'cosrux 1',
        'description_ar' => 'وصف المنتج',
        'description_en' => 'product description',
        'price' => 100,
        'image' => 'uploads/4418e83b-10fd-4875-945d-831000468eef.png'
    ]);
    $response = getJson('/api/app/home/best-seller-products');

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
    $response = getJson('/api/app/home/categories');
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
