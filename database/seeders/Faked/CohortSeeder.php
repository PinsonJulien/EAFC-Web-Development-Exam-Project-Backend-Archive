<?php

namespace Database\Seeders\Faked;

use App\Models\Cohort;
use Illuminate\Database\Seeder;

class CohortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cohort::factory()
            ->count(10)
            ->create();
    }
}
