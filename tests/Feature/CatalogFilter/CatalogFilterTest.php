<?php

use function Pest\Laravel\getJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('can fetch catalog filters', function () {
    $response = getJson('/api/catalog-filters');

    $response->assertStatus(404);
});
