<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_get_token()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token', 'admin']);
    }

    public function test_admin_cannot_login_with_wrong_password()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(422); // Validation exception
    }

    public function test_admin_can_access_protected_route_using_token()
    {
        $admin = Admin::factory()->create();
        
        // Simulating Sanctum authentication for Admin
        $this->actingAs($admin, 'sanctum');

        $response = $this->getJson('/api/admin/me');

        $response->assertStatus(200)
                 ->assertJson(['id' => $admin->id]);
    }

    public function test_regular_user_cannot_access_admin_route()
    {
        $user = User::factory()->create();

        // Acting as a regular User
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/admin/me');

        // Expect 403 Forbidden because user is NOT an Admin instance
        $response->assertStatus(403);
    }

    public function test_guest_cannot_access_admin_route()
    {
        $response = $this->getJson('/api/admin/me');

        // Expect 401 Unauthorized because checks auth middleware first
        $response->assertStatus(401);
    }
}
