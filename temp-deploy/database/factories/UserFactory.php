<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // Import User model for role constants

class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();

        return [
            // 'name' => fake()->name(), // <--- MAKE SURE THIS LINE IS DELETED OR COMMENTED OUT
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => strtolower(Str::slug($firstName . $lastName)) . fake()->unique()->numerify('###'), // More robust unique username
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'), // Default password 'password'
            'remember_token' => Str::random(10),
            'role' => User::ROLE_USER, // Default role for seeded users (using constant from User model)
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->stateAbbr(),
            'zip_code' => fake()->postcode(),
            'phone_number' => fake()->phoneNumber(),
            'account_number' => 'ACC' . fake()->unique()->numerify('#######'),
            'service_type' => fake()->randomElement(['Internet Only', 'Internet + TV', 'Full Package']),
            'secondary_first_name' => fake()->optional(0.7)->firstName(),
            'secondary_last_name' => function (array $attributes) { // Ensure this only provides a value if secondary_first_name exists
                return $attributes['secondary_first_name'] ? fake()->lastName() : null;
            },
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Configure the factory to create an admin user.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'first_name' => 'Admin',       // Provide first_name
            'last_name' => 'User',        // Provide last_name
            // 'name' => 'Admin User',    // REMOVE THIS if it was here
            'username' => 'adminuser',    // Set a specific admin username
            'email' => 'admin@example.com',
            'role' => User::ROLE_ADMIN,   // Use constant from User model
        ]);
    }
}