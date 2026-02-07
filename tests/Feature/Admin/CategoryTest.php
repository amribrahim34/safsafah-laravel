<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list categories', function () {
    $user = User::factory()->create();
    Category::factory()->count(3)->create();

    $response = $this->actingAs($user)->getJson('/api/admin/categories');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name_ar', 'name_en']
            ],
            'meta',
            'links'
        ]);
});

test('can create category', function () {
    $user = User::factory()->create();
    $data = [
        'name_ar' => 'Test Cat AR',
        'name_en' => 'Test Cat EN',
    ];

    $response = $this->actingAs($user)->postJson('/api/admin/categories', $data);

    $response->assertStatus(201)
        ->assertJsonFragment($data);

    $this->assertDatabaseHas('categories', $data);
});

test('can show category', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->getJson("/api/admin/categories/{$category->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $category->id,
            'name_ar' => $category->name_ar,
            'name_en' => $category->name_en,
        ]);
});

test('can update category', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $data = [
        'name_ar' => 'Updated Cat AR',
        'name_en' => 'Updated Cat EN',
    ];

    $response = $this->actingAs($user)->putJson("/api/admin/categories/{$category->id}", $data);

    $response->assertStatus(200)
        ->assertJsonFragment($data);

    $this->assertDatabaseHas('categories', $data);
});

test('can delete category', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->deleteJson("/api/admin/categories/{$category->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('categories', ['id' => $category->id]);
});
