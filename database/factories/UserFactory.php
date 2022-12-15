<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' =>fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'remember_token' => Str::random(10),

            'lastname' => fake()->lastName(),
            'firstname' => fake()->firstName(),
            'nationality_country_id' => fake()->randomElement(Country::query()->get('id')),
            'birthdate' => fake()->date(),
            'address' => fake()->streetAddress(),
            'postal_code' => fake()->postcode(),
            'address_country_id' => fake()->randomElement(Country::query()->get('id')),
            'phone' => fake()->phoneNumber(),
            'picture' => fake()->imageUrl(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
