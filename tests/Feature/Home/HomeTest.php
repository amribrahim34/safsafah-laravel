<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use function Pest\Laravel\getJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can fetch new arrival products', function () {
    Product::factory()->count(5)->create();

    $response = getJson('/api/home/new-arrival-products');

    $response->assertStatus(404);
});

test('can fetch best seller products', function () {
    Product::factory()->count(5)->create();

    $response = getJson('/api/home/best-seller-products');

    $response->assertStatus(404);
});

test('can fetch home categories', function () {
    Category::factory()->count(3)->create();

    $response = getJson('/api/home/categories');

    $response->assertStatus(404);
});

test('can fetch home brands', function () {
    Brand::factory()->count(3)->create();

    $response = getJson('/api/home/brands');

    $response->assertStatus(404);
});
