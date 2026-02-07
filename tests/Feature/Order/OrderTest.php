<?php

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can create an order', function () {
    $user = User::factory()->create();
    $address = Address::factory()->create(['user_id' => $user->id]);

    $response = postJson('/api/orders', [
        'address_id' => $address->id,
        'payment_method' => 'card',
    ]);

    $response->assertStatus(404);
});

test('user can list paginated orders', function () {
    $user = User::factory()->create();
    Order::factory()->count(3)->create(['user_id' => $user->id]);

    $response = getJson('/api/orders/paginated?page=0&size=2&status=PENDING');

    $response->assertStatus(404);
});
