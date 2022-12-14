<?php

namespace Database\Factories;

use App\Models\EducationLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formation>
 */
class FormationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->sentence(5),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'education_level_id' => fake()->randomElement(EducationLevel::query()->get('id')),
        ];
    }
}
