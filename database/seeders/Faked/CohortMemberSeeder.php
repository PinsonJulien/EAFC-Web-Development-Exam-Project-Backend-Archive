<?php

namespace Database\Seeders\Faked;

use App\Models\CohortMember;
use Illuminate\Database\Seeder;

class CohortMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CohortMember::factory()
            ->count(10)
            ->create();
    }
}
