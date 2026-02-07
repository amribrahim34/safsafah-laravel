<?php

use App\Models\ContactMessages;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list contact messages', function () {
    $user = User::factory()->create();
    ContactMessages::factory()->count(3)->create();

    $response = $this->actingAs($user)->getJson('/api/admin/contact-messages');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'message']
            ],
            'meta',
            'links'
        ]);
});

test('can show contact message', function () {
    $user = User::factory()->create();
    $message = ContactMessages::factory()->create();

    $response = $this->actingAs($user)->getJson("/api/admin/contact-messages/{$message->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $message->id,
            'name' => $message->name,
        ]);
});

test('can delete contact message', function () {
    $user = User::factory()->create();
    $message = ContactMessages::factory()->create();

    $response = $this->actingAs($user)->deleteJson("/api/admin/contact-messages/{$message->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
});
