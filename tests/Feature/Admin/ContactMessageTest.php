<?php

use App\Models\ContactMessages;
use App\Models\Admin;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can list contact messages', function () {
    $admin = Admin::factory()->create();
    ContactMessages::factory()->count(3)->create();

    Sanctum::actingAs($admin, ['*']);
    $response = $this->getJson('/api/admin/contact-messages');

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
    $admin = Admin::factory()->create();
    $message = ContactMessages::factory()->create();

    Sanctum::actingAs($admin, ['*']);
    $response = $this->getJson("/api/admin/contact-messages/{$message->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'id' => $message->id,
            'name' => $message->name,
        ]);
});

test('can delete contact message', function () {
    $admin = Admin::factory()->create();
    $message = ContactMessages::factory()->create();

    Sanctum::actingAs($admin, ['*']);
    $response = $this->deleteJson("/api/admin/contact-messages/{$message->id}");

    $response->assertStatus(204);

    $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
});
