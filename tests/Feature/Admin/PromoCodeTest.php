<?php

use App\Models\PromoCode;
use App\Models\Admin;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list promo codes', function () {
    $admin = Admin::factory()->create();
    PromoCode::factory()->count(3)->create();

    Sanctum::actingAs($admin, ['*']);
    $response = $this->getJson('/api/admin/promo-codes');

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
    $admin = Admin::factory()->create();
    $data = [
        'code' => 'NEWPROMO2025',
        'discount' => 10.5,
        'is_percent' => true,
        'active' => true
    ];

    Sanctum::actingAs($admin, ['*']);
    $response = $this->postJson('/api/admin/promo-codes', $data);

    $response->assertStatus(201)
        ->assertJsonFragment(['code' => 'NEWPROMO2025']);

    $this->assertDatabaseHas('promo_codes', ['code' => 'NEWPROMO2025']);
});

test('can show promo code', function () {
    $admin = Admin::factory()->create();
    $promoCode = PromoCode::factory()->create();

    Sanctum::actingAs($admin, ['*']);
    $response = $this->getJson("/api/admin/promo-codes/{$promoCode->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $promoCode->id,
            'code' => $promoCode->code,
        ]);
});

test('can update promo code', function () {
    $admin = Admin::factory()->create();
    $promoCode = PromoCode::factory()->create();

    $data = [
        'code' => 'UPDATEDPROMO',
        'discount' => 20,
        'is_percent' => false,
        'active' => true
    ];

    Sanctum::actingAs($admin, ['*']);
    $response = $this->putJson("/api/admin/promo-codes/{$promoCode->id}", $data);

    $response->assertStatus(200)
        ->assertJsonFragment(['code' => 'UPDATEDPROMO']);

    $this->assertDatabaseHas('promo_codes', ['code' => 'UPDATEDPROMO']);
});

test('can delete promo code', function () {
    $admin = Admin::factory()->create();
    $promoCode = PromoCode::factory()->create();

    Sanctum::actingAs($admin, ['*']);
    $response = $this->deleteJson("/api/admin/promo-codes/{$promoCode->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('promo_codes', ['id' => $promoCode->id]);
});
