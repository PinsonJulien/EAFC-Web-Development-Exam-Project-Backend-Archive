<?php

namespace Database\Factories;

use App\Models\Formation;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => fake()->randomElement(User::query()->get('id')),
            'formation_id' => fake()->randomElement(Formation::query()->get('id')),
            'status_id' => fake()->randomElement(Status::query()->get('id')),
            'message' => fake()->text(),
        ];
    }
}
