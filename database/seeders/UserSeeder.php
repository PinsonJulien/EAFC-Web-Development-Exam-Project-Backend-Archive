<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Formation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(60)
            /*
            ->has(
                Formation::factory()
                ->count(2)
                ->hasCourses(3),
                'studentFormations'
            )
            ->hasStudentCourses(3)
            */
            ->create();
    }
}
