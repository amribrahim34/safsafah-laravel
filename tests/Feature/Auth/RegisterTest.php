<?php

use function Pest\Laravel\postJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can register with valid data', function () {
    $response = postJson('/api/auth/register', [
        'name' => 'Test User',
        'email' => 'new@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'mobile' => '1234567890',
    ]);

    $response->assertSuccessful()
        ->assertJsonStructure([
            'token',
            'user' => [
                'id',
                'name',
                'email',
                'mobile',
                'points',
            ]
        ]);
    $this->assertDatabaseHas('users', ['email' => 'new@example.com']);
});

test('register fails with missing fields', function () {
    $response = postJson('/api/auth/register', [
        'name' => 'Test User',
    ]);

    $response->assertStatus(422);
    // Future assertion:
    // $response->assertStatus(422);
});
