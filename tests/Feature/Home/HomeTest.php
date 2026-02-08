<?php

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use function Pest\Laravel\getJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can fetch home data', function () {
    \App\Models\Product::factory()->count(5)->create();
    \App\Models\Category::factory()->count(3)->create();
    \App\Models\Brand::factory()->count(3)->create();

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
