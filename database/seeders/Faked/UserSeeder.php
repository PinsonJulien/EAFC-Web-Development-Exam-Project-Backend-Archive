<?php

namespace Database\Seeders\Faked;

use App\Models\User;
use Illuminate\Database\Seeder;

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
