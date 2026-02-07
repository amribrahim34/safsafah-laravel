<?php

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list products', function () {
    $user = User::factory()->create();
    // Ensure factories exist for relations
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    
    Product::factory()->count(3)->create([
        'category_id' => $category->id,
        'brand_id' => $brand->id
    ]);

    $response = $this->actingAs($user)->getJson('/api/admin/products');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name_ar', 'name_en', 'price']
            ],
            'meta',
            'links'
        ]);
});

test('can create product', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();

    $data = [
        'name_ar' => 'Test Product AR',
        'name_en' => 'Test Product EN',
        'price' => 100.50,
        'category_id' => $category->id,
        'brand_id' => $brand->id,
        // Optional fields
        'description_ar' => 'Desc AR',
        'description_en' => 'Desc EN',
    ];

    $response = $this->actingAs($user)->postJson('/api/admin/products', $data);

    $response->assertStatus(201)
        ->assertJsonFragment(['name_en' => 'Test Product EN']);

    $this->assertDatabaseHas('products', ['name_en' => 'Test Product EN']);
});

test('can show product', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'brand_id' => $brand->id
    ]);

    $response = $this->actingAs($user)->getJson("/api/admin/products/{$product->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $product->id,
            'name_ar' => $product->name_ar,
        ]);
});

test('can update product', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'brand_id' => $brand->id
    ]);

    $data = [
        'name_ar' => 'Updated Product AR',
        'name_en' => 'Updated Product EN',
        'price' => 150.00,
        'category_id' => $category->id,
        'brand_id' => $brand->id,
    ];

    $response = $this->actingAs($user)->putJson("/api/admin/products/{$product->id}", $data);

    $response->assertStatus(200)
        ->assertJsonFragment(['name_en' => 'Updated Product EN']);

    $this->assertDatabaseHas('products', ['name_en' => 'Updated Product EN']);
});

test('can delete product', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $brand = Brand::factory()->create();
    
    $product = Product::factory()->create([
        'category_id' => $category->id,
        'brand_id' => $brand->id
    ]);

    $response = $this->actingAs($user)->deleteJson("/api/admin/products/{$product->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});
