<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SkinType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

test('can filter products by categoryId', function () {
    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();

    $product1 = Product::factory()->create(['category_id' => $category1->id]);
    $product2 = Product::factory()->create(['category_id' => $category2->id]);
    $product3 = Product::factory()->create(['category_id' => $category1->id]);

    $response = getJson("/api/products?categoryId={$category1->id}");

    $response->assertOk()
        ->assertJsonCount(2, 'products')
        ->assertJsonPath('products.0.id', $product1->id)
        ->assertJsonPath('products.1.id', $product3->id);
});

test('can fetch products list with correct response structure', function () {
    [$product1, $brand1, $category1] = createProductWithRelations([
        'name_ar' => 'سيرم الحلزون',
        'name_en' => 'snail serum',
        'description_ar' => 'حمادة يلعب',
        'description_en' => 'lorum epsom',
        'price' => 12,
        'sku' => 'SNA-SER-642',
        'image' => 'uploads/d7eadaf4-a3dd-4e8c-9e21-dafbcc2eeb1f.png',
    ]);

    [$product2, $brand2, $category2] = createProductWithRelations([
        'name_ar' => 'واقي شمس لاروش',
        'name_en' => 'La Roche-Posay sunscreen',
        'description_ar' => 'تفاصيل طويلة',
        'description_en' => '',
        'price' => 522,
        'sku' => 'LRP-SUN-123',
        'image' => null,
    ], true, true);

    $response = getJson('/api/products');

    $response->assertOk()
        ->assertJsonCount(2, 'products')
        ->assertJsonStructure([
            'products' => [
                '*' => [
                    'id',
                    'nameAr',
                    'nameEn',
                    'descriptionAr',
                    'descriptionEn',
                    'categoryId',
                    'brandId',
                    'price',
                    'image',
                    'sku',
                ],
            ],
            'total',
            'page',
            'limit',
        ])
        // Test first product has the expected values
        ->assertJsonPath('products.0.id', $product1->id)
        ->assertJsonPath('products.0.nameAr', 'سيرم الحلزون')
        ->assertJsonPath('products.0.nameEn', 'snail serum')
        ->assertJsonPath('products.0.categoryId', $category1->id)
        ->assertJsonPath('products.0.brandId', $brand1->id)
        ->assertJsonPath('products.0.price', $product1->price)
        ->assertJsonPath('products.0.sku', 'SNA-SER-642')
        // Test second product has null category and brand
        ->assertJsonPath('products.1.id', $product2->id)
        ->assertJsonPath('products.1.categoryId', null)
        ->assertJsonPath('products.1.brandId', null)
        ->assertJsonPath('products.1.price', $product2->price);
});


test('can filter products by brandId', function () {
    $brand1 = Brand::factory()->create();
    $brand2 = Brand::factory()->create();

    $product1 = Product::factory()->create(['brand_id' => $brand1->id]);
    $product2 = Product::factory()->create(['brand_id' => $brand2->id]);
    $product3 = Product::factory()->create(['brand_id' => $brand1->id]);

    $response = getJson("/api/products?brandId={$brand1->id}");

    $response->assertOk()
        ->assertJsonCount(2, 'products')
        ->assertJsonPath('products.0.id', $product1->id)
        ->assertJsonPath('products.1.id', $product3->id);
});

test('can filter products by skinTypeId', function () {
    $skinType1 = SkinType::factory()->create();
    $skinType2 = SkinType::factory()->create();

    $product1 = Product::factory()->create();
    $product1->skinTypes()->attach($skinType1->id);

    $product2 = Product::factory()->create();
    $product2->skinTypes()->attach($skinType2->id);

    $product3 = Product::factory()->create();
    $product3->skinTypes()->attach($skinType1->id);

    $response = getJson("/api/products?skinTypeId={$skinType1->id}");

    $response->assertOk()
        ->assertJsonCount(2, 'products')
        ->assertJsonPath('products.0.id', $product1->id)
        ->assertJsonPath('products.1.id', $product3->id);
});

test('can filter products by minPrice', function () {
    Product::factory()->create(['price' => 10.0]);
    $product2 = Product::factory()->create(['price' => 50.0]);
    $product3 = Product::factory()->create(['price' => 100.0]);

    $response = getJson('/api/products?minPrice=50');

    $response->assertOk()
        ->assertJsonCount(2, 'products')
        ->assertJsonPath('products.0.id', $product2->id)
        ->assertJsonPath('products.1.id', $product3->id);
});

test('can filter products by maxPrice', function () {
    $product1 = Product::factory()->create(['price' => 10.0]);
    $product2 = Product::factory()->create(['price' => 50.0]);
    Product::factory()->create(['price' => 100.0]);

    $response = getJson('/api/products?maxPrice=50');

    $response->assertOk()
        ->assertJsonCount(2, 'products')
        ->assertJsonPath('products.0.id', $product1->id)
        ->assertJsonPath('products.1.id', $product2->id);
});

test('can filter products by price range with both minPrice and maxPrice', function () {
    Product::factory()->create(['price' => 10.0]);
    $product2 = Product::factory()->create(['price' => 50.0]);
    $product3 = Product::factory()->create(['price' => 75.0]);
    Product::factory()->create(['price' => 150.0]);

    $response = getJson('/api/products?minPrice=50&maxPrice=100');

    $response->assertOk()
        ->assertJsonCount(2, 'products')
        ->assertJsonPath('products.0.id', $product2->id)
        ->assertJsonPath('products.1.id', $product3->id);
});

test('can search products by searchQuery', function () {
    $product1 = Product::factory()->create([
        'name_ar' => 'سيرم فيتامين سي',
        'name_en' => 'Vitamin C Serum',
    ]);

    Product::factory()->create([
        'name_ar' => 'كريم مرطب',
        'name_en' => 'Moisturizing Cream',
    ]);

    $product3 = Product::factory()->create([
        'name_ar' => 'سيرم الريتينول',
        'name_en' => 'Retinol Serum',
    ]);

    // Search in Arabic
    $response = getJson('/api/products?searchQuery=سيرم');
    $response->assertOk()
        ->assertJsonCount(2, 'products')
        ->assertJsonPath('products.0.id', $product1->id)
        ->assertJsonPath('products.1.id', $product3->id);

    // Search in English
    $response = getJson('/api/products?searchQuery=Serum');
    $response->assertOk()
        ->assertJsonCount(2, 'products');
});

test('can filter products with combined filters', function () {
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    $skinType = SkinType::factory()->create();

    $product1 = Product::factory()->create([
        'category_id' => $category->id,
        'brand_id' => $brand->id,
        'price' => 50.0,
        'name_en' => 'Vitamin Serum',
    ]);
    $product1->skinTypes()->attach($skinType->id);

    Product::factory()->create([
        'category_id' => $category->id,
        'brand_id' => $brand->id,
        'price' => 200.0, // Outside price range
        'name_en' => 'Vitamin Serum',
    ]);

    Product::factory()->create([
        'category_id' => $category->id,
        'price' => 50.0,
        'name_en' => 'Different Product', // Different search
    ]);

    $response = getJson("/api/products?categoryId={$category->id}&brandId={$brand->id}&skinTypeId={$skinType->id}&minPrice=30&maxPrice=100&searchQuery=Vitamin");

    $response->assertOk()
        ->assertJsonCount(1, 'products')
        ->assertJsonPath('products.0.id', $product1->id);
});

test('supports pagination with limit parameter', function () {
    Product::factory()->count(20)->create();

    $response = getJson('/api/products?limit=5');

    $response->assertOk()
        ->assertJsonCount(5, 'products')
        ->assertJsonPath('limit', 5)
        ->assertJsonPath('total', 20);
});

test('supports pagination with page parameter', function () {
    $products = Product::factory()->count(15)->create();

    $response = getJson('/api/products?limit=5&page=2');

    $response->assertOk()
        ->assertJsonCount(5, 'products')
        ->assertJsonPath('page', 2)
        ->assertJsonPath('limit', 5);
});

test('uses default pagination limit when not specified', function () {
    Product::factory()->count(15)->create();

    $response = getJson('/api/products');

    $response->assertOk()
        ->assertJsonPath('limit', 12);
});
