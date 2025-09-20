<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Reagan Mukabana',
            'email' => 'reaganmukabana@gmail.com',
            'password' => bcrypt('123456789'),
            'role' => 'admin',
        ]);

        // Create regular user
        User::factory()->create([
            'name' => 'Miriam Wendy',
            'email' => 'miriamwendy@gmail.com',
            'password' => bcrypt('123456789'),
            'role' => 'user',
        ]);
    }
}
