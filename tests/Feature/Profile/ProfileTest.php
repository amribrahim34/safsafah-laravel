<?php

use App\Models\Address;
use App\Models\User;
use function Pest\Laravel\getJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can get their profile', function () {
    $user = User::factory()->create();

    $response = getJson('/api/profile/me');

    $response->assertStatus(404);
});

test('user can list their addresses', function () {
    $user = User::factory()->create();
    Address::factory()->count(2)->create(['user_id' => $user->id]);

    $response = getJson('/api/profile/addresses');

    $response->assertStatus(404);
});
