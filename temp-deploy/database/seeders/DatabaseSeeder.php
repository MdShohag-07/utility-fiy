<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Import Hash for password

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Option 1: Create a specific test user with first_name and last_name
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'username' => 'testuser', // Add other required/desired fields
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // Set a default password
            'role' => User::ROLE_USER, // Or User::ROLE_ADMIN if it's an admin
            'email_verified_at' => now(), // Mark as verified
            // Add other fields like account_number, address, etc. if needed for this test user
        ]);

        // Option 2: Create a specific admin user using the factory state
        // Make sure your UserFactory.php has the ->admin() state defined
        User::factory()->admin()->create([
            'email' => 'admin@example.com', // You can override the factory's default admin email here
            'password' => Hash::make('adminpassword'),
        ]);


        // Option 3: If you want to create a few more random users using the factory defaults
        User::factory(5)->create(); // This will use the default first_name, last_name from your UserFactory

    }
}