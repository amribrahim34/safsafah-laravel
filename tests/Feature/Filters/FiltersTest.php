<?php

use App\Models\ActiveIngredient;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SkinConcern;
use App\Models\SkinType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

test('can fetch categories filter data - only returns categories with products', function () {
    // Create category with products
    $categoryWithProducts = Category::factory()->create([
        'name_ar' => 'العناية بالبشرة',
        'name_en' => 'Skin Care',
        'image' => 'uploads/category.png'
    ]);
    
    // Create category without products
    $categoryWithoutProducts = Category::factory()->create([
        'name_ar' => 'فارغ',
        'name_en' => 'Empty',
    ]);
    
    // Create a product associated with the first category
    Product::factory()->create(['category_id' => $categoryWithProducts->id]);
    
    $response = getJson('/api/filters/categories');
    
    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJson([
            'data' => [
                [
                    'id' => $categoryWithProducts->id,
                    'nameAr' => 'العناية بالبشرة',
                    'nameEn' => 'Skin Care',
                    'image' => $categoryWithProducts->image_url,
                ]
            ]
        ])
        ->assertJsonMissing([
            'id' => $categoryWithoutProducts->id
        ]);
});

test('can fetch brands filter data - only returns brands with products', function () {
    // Create brand with products
    $brandWithProducts = Brand::factory()->create([
        'name_ar' => 'سيتافيل',
        'name_en' => 'Cetaphil',
        'logo' => 'uploads/brand.png'
    ]);
    
    // Create brand without products
    $brandWithoutProducts = Brand::factory()->create([
        'name_ar' => 'فارغ',
        'name_en' => 'Empty',
    ]);
    
    // Create a product associated with the first brand
    Product::factory()->create(['brand_id' => $brandWithProducts->id]);
    
    $response = getJson('/api/filters/brands');
    
    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJson([
            'data' => [
                [
                    'id' => $brandWithProducts->id,
                    'nameAr' => 'سيتافيل',
                    'nameEn' => 'Cetaphil',
                    'logo' => $brandWithProducts->logo_url,
                ]
            ]
        ])
        ->assertJsonMissing([
            'id' => $brandWithoutProducts->id
        ]);
});

test('can fetch skin types filter data - only returns skin types with products', function () {
    // Create skin type with products
    $skinTypeWithProducts = SkinType::factory()->create([
        'name_ar' => 'بشرة دهنية',
        'name_en' => 'Oily Skin',
    ]);
    
    // Create skin type without products
    $skinTypeWithoutProducts = SkinType::factory()->create([
        'name_ar' => 'فارغ',
        'name_en' => 'Empty',
    ]);
    
    // Create a product and associate it with the first skin type
    $product = Product::factory()->create();
    $product->skinTypes()->attach($skinTypeWithProducts->id);
    
    $response = getJson('/api/filters/skin-types');
    
    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJson([
            'data' => [
                [
                    'id' => $skinTypeWithProducts->id,
                    'name_ar' => 'بشرة دهنية',
                    'name_en' => 'Oily Skin',
                ]
            ]
        ])
        ->assertJsonMissing([
            'id' => $skinTypeWithoutProducts->id
        ]);
});

test('can fetch skin concerns filter data - only returns skin concerns with products', function () {
    // Create skin concern with products
    $skinConcernWithProducts = SkinConcern::factory()->create([
        'name_ar' => 'حب الشباب',
        'name_en' => 'Acne',
    ]);
    
    // Create skin concern without products
    $skinConcernWithoutProducts = SkinConcern::factory()->create([
        'name_ar' => 'فارغ',
        'name_en' => 'Empty',
    ]);
    
    // Create a product and associate it with the first skin concern
    $product = Product::factory()->create();
    $product->skinConcerns()->attach($skinConcernWithProducts->id);
    
    $response = getJson('/api/filters/skin-concerns');
    
    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJson([
            'data' => [
                [
                    'id' => $skinConcernWithProducts->id,
                    'name_ar' => 'حب الشباب',
                    'name_en' => 'Acne',
                ]
            ]
        ])
        ->assertJsonMissing([
            'id' => $skinConcernWithoutProducts->id
        ]);
});

test('can fetch active ingredients filter data - only returns active ingredients with products', function () {
    // Create active ingredient with products
    $activeIngredientWithProducts = ActiveIngredient::factory()->create([
        'name_ar' => 'حمض الهيالورونيك',
        'name_en' => 'Hyaluronic Acid',
    ]);
    
    // Create active ingredient without products
    $activeIngredientWithoutProducts = ActiveIngredient::factory()->create([
        'name_ar' => 'فارغ',
        'name_en' => 'Empty',
    ]);
    
    // Create a product and associate it with the first active ingredient
    $product = Product::factory()->create();
    $product->activeIngredients()->attach($activeIngredientWithProducts->id);
    
    $response = getJson('/api/filters/active-ingredients');
    
    $response->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJson([
            'data' => [
                [
                    'id' => $activeIngredientWithProducts->id,
                    'nameAr' => 'حمض الهيالورونيك',
                    'nameEn' => 'Hyaluronic Acid',
                ]
            ]
        ])
        ->assertJsonMissing([
            'id' => $activeIngredientWithoutProducts->id
        ]);
});

test('filters return empty array when no products exist', function () {
    // Create entities without any products
    Category::factory()->create();
    Brand::factory()->create();
    SkinType::factory()->create();
    SkinConcern::factory()->create();
    ActiveIngredient::factory()->create();
    
    // All filter endpoints should return empty arrays
    getJson('/api/filters/categories')->assertOk()->assertJson(['data' => []]);
    getJson('/api/filters/brands')->assertOk()->assertJson(['data' => []]);
    getJson('/api/filters/skin-types')->assertOk()->assertJson(['data' => []]);
    getJson('/api/filters/skin-concerns')->assertOk()->assertJson(['data' => []]);
    getJson('/api/filters/active-ingredients')->assertOk()->assertJson(['data' => []]);
});
