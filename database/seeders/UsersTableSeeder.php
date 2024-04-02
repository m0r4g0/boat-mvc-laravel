<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create the first user
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password'
        ]);

        // Create the second user
        User::factory()->create([
            'id' => 2,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password'
        ]);
    }
}
