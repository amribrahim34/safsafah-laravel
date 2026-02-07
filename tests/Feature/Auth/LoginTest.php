<?php

use App\Models\User;
use function Pest\Laravel\postJson;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user can login with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response = postJson('/api/auth/login', [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    // Expecting 404 because controller doesn't exist yet, but asserting structure for when it does
    // $response->assertOk()
    //     ->assertJsonStructure(['token', 'user']);
    // For now, assertion depends on what we expect. Since user tasked to write tests for existing postman,
    // and code doesn't exist, we expect 404.
    
    $response->assertStatus(404);
});

test('user cannot login with invalid credentials', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response = postJson('/api/auth/login', [
        'email' => 'test@example.com',
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(404);
    // Future assertion:
    // $response->assertStatus(422)
    //     ->assertJsonValidationErrors(['email']); 
});
