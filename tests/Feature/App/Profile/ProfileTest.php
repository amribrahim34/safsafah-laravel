<?php

use App\Models\Address;
use App\Models\User;
use function Pest\Laravel\getJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can get their profile', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->getJson('/api/app/profile');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'mobile',
                'points',
            ]
        ]);
});

test('user can list their addresses', function () {
    $user = User::factory()->create();
    Address::factory()->count(2)->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->getJson('/api/app/profile/addresses');

    $response->assertOk();
});
