<?php

use App\Models\ActiveIngredient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list active ingredients', function () {
    $user = User::factory()->create();
    ActiveIngredient::factory()->count(3)->create();

    $response = $this->actingAs($user)->getJson('/api/admin/active-ingredients');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name_ar', 'name_en']
            ],
            'meta',
            'links'
        ]);
});

test('can create active ingredient', function () {
    $user = User::factory()->create();
    $data = [
        'name_ar' => 'Test AR',
        'name_en' => 'Test EN',
    ];

    $response = $this->actingAs($user)->postJson('/api/admin/active-ingredients', $data);

    $response->assertStatus(201)
        ->assertJsonFragment($data);

    $this->assertDatabaseHas('active_ingredients', $data);
});

test('can show active ingredient', function () {
    $user = User::factory()->create();
    $ingredient = ActiveIngredient::factory()->create();

    $response = $this->actingAs($user)->getJson("/api/admin/active-ingredients/{$ingredient->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $ingredient->id,
            'name_ar' => $ingredient->name_ar,
            'name_en' => $ingredient->name_en,
        ]);
});

test('can update active ingredient', function () {
    $user = User::factory()->create();
    $ingredient = ActiveIngredient::factory()->create();

    $data = [
        'name_ar' => 'Updated AR',
        'name_en' => 'Updated EN',
    ];

    $response = $this->actingAs($user)->putJson("/api/admin/active-ingredients/{$ingredient->id}", $data);

    $response->assertStatus(200)
        ->assertJsonFragment($data);

    $this->assertDatabaseHas('active_ingredients', $data);
});

test('can delete active ingredient', function () {
    $user = User::factory()->create();
    $ingredient = ActiveIngredient::factory()->create();

    $response = $this->actingAs($user)->deleteJson("/api/admin/active-ingredients/{$ingredient->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('active_ingredients', ['id' => $ingredient->id]);
});
