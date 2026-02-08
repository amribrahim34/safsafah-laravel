<?php

use App\Models\Product;
use function Pest\Laravel\getJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can fetch products list', function () {
    Product::factory()->count(5)->create();

    $response = getJson('/api/products');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'nameEn',
                    'price',
                    'image',
                ]
            ]
        ]);
});
