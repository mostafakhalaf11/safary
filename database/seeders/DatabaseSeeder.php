<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'khalaf',
            'email' => 'khalaf@safary.com',
            'phone_number' => '+201153470446',
            'type' => 'super-admin',
            'password' => bcrypt('Khalaf1997'),
            'profile_photo_path' => null,
            'is_verified' => true,
            'is_active' => true,
            'is_deleted' => false,
            'email_verified_at' => now(),
        ]);
    }
}
