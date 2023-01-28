<?php

namespace Database\Seeders\Faked;

use App\Models\Formation;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Formation::factory()
            ->count(20)
            ->hasCourses(5)
            ->create();
    }
}
