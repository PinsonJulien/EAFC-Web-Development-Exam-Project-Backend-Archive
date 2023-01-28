<?php

namespace Database\Seeders\Constants;

use App\Models\CohortRole;
use Illuminate\Database\Seeder;

class CohortRoleSeeder extends Seeder
{
    /**
     * Seed the database with all the CohortRoles
     *
     * @return void
     */
    public function run(): void
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
