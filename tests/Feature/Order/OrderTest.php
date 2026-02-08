<?php

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can create an order', function () {
    $user = User::factory()->create();
    $cart = \App\Models\Cart::factory()->create(['user_id' => $user->id]);
    \App\Models\CartItem::factory()->create(['cart_id' => $cart->id]);

    $response = $this->actingAs($user)->postJson('/api/orders', [
        'customerName' => 'Test User',
        'customerAddress' => '123 Test St',
        'customerMobile' => '01010101010',
        'paymentType' => 'CASH_ON_DELIVERY',
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id',
                'total',
                'status',
                'items',
            ]
        ]);
});

test('user can list paginated orders', function () {
    $user = User::factory()->create();
    Order::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->getJson('/api/orders/paginated?page=0&size=2&status=PENDING');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'total',
                    'status',
                ]
            ]
        ]);
});
