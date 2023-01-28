<?php

namespace Database\Seeders\Constants;

use App\Models\EducationLevel;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    /**
     * Seed the database with all the Education levels
     *
     * @return void
     */
    public function run(): void
    {
        EducationLevel::insert(
            [
                ['name' => 'Master'],
                ['name' => 'Bac'],
                ['name' => 'BES'],
                ['name' => 'DS'],
                ['name' => 'DI'],
            ]
        );
    }
}
