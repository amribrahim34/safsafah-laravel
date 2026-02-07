<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@safsafah.com'],
            [
                'name' => 'Admin User',
                'password' => '$2a$10$1u6m6nEV1ezA1UpkXsddoeYZW.P2DtRZek.VI16oOvD5L9WPqoH22',
                'mobile' => '1234567890',
                'points' => 0,
            ]
        );
    }
}
