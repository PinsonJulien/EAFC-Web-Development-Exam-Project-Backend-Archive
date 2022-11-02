<?php

namespace Database\Seeders;

use App\Models\FormationCourse;
use Illuminate\Database\Seeder;

class FormationCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FormationCourse::factory()
            ->times(10)
            ->create();
    }
}
