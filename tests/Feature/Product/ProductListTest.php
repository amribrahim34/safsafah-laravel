<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\getJson;

uses(RefreshDatabase::class);

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
