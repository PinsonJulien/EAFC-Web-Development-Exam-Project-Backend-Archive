<?php

namespace Database\Seeders;

use App\Models\UserCohort;
use Illuminate\Database\Seeder;

class UserCohortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserCohort::factory()
            ->count(10)
            ->create();
    }
}
