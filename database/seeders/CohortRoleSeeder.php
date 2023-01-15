<?php

namespace Database\Seeders;

use App\Models\CohortRole;
use Illuminate\Database\Seeder;

class CohortRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CohortRole::insert(
            [
                ['name' => 'student', 'id' => 1],
                ['name' => 'assistant', 'id' => 2],
                ['name' => 'teacher', 'id' => 3],
            ]
        );
    }
}
