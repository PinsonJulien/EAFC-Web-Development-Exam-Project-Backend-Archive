<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Formation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormationCourse>
 */
class FormationCourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'formation_id' => fake()->randomElement(Formation::query()->get('id')),
            'course_id' => fake()->randomElement(Course::query()->get('id')),
        ];
    }
}
