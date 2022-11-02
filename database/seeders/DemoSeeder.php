<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            EducationLevelSeeder::class,
            FormationSeeder::class,
            CourseSeeder::class,
            FormationCourseSeeder::class,
        ]);
    }
}
