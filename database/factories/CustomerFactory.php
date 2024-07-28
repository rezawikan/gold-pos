<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'address' => fake()->address(),
            //            'email_verified_at' => now(),
            //            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            //            'remember_token' => null,
            //            'created_at' => now(),
            //            'updated_at' => now(),
            //            'deleted_at' => null,
            'phone_number' => fake()->phoneNumber(),
        ];
    }
}
