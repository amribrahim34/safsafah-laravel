<?php

use App\Models\PromoCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list promo codes', function () {
    $user = User::factory()->create();
    PromoCode::factory()->count(3)->create();

    $response = $this->actingAs($user)->getJson('/api/admin/promo-codes');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'code', 'discount']
            ],
            'meta',
            'links'
        ]);
});

test('can create promo code', function () {
    $user = User::factory()->create();
    $data = [
        'code' => 'NEWPROMO2025',
        'discount' => 10.5,
        'is_percent' => true,
        'active' => true
    ];

    $response = $this->actingAs($user)->postJson('/api/admin/promo-codes', $data);

    $response->assertStatus(201)
        ->assertJsonFragment(['code' => 'NEWPROMO2025']);

    $this->assertDatabaseHas('promo_codes', ['code' => 'NEWPROMO2025']);
});

test('can show promo code', function () {
    $user = User::factory()->create();
    $promoCode = PromoCode::factory()->create();

    $response = $this->actingAs($user)->getJson("/api/admin/promo-codes/{$promoCode->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $promoCode->id,
            'code' => $promoCode->code,
        ]);
});

test('can update promo code', function () {
    $user = User::factory()->create();
    $promoCode = PromoCode::factory()->create();

    $data = [
        'code' => 'UPDATEDPROMO',
        'discount' => 20,
        'is_percent' => false,
        'active' => true
    ];

    $response = $this->actingAs($user)->putJson("/api/admin/promo-codes/{$promoCode->id}", $data);

    $response->assertStatus(200)
        ->assertJsonFragment(['code' => 'UPDATEDPROMO']);

    $this->assertDatabaseHas('promo_codes', ['code' => 'UPDATEDPROMO']);
});

test('can delete promo code', function () {
    $user = User::factory()->create();
    $promoCode = PromoCode::factory()->create();

    $response = $this->actingAs($user)->deleteJson("/api/admin/promo-codes/{$promoCode->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('promo_codes', ['id' => $promoCode->id]);
});
