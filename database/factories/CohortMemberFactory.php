<?php

namespace Database\Factories;

use App\Models\Cohort;
use App\Models\CohortRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CohortMember>
 */
class CohortMemberFactory extends Factory
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
            'cohort_id' => fake()->randomElement(Cohort::query()->get('id')),
            'cohort_role_id' => fake()->randomElement(CohortRole::query()->get('id')),
        ];
    }
}
