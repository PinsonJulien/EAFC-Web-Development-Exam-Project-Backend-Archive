<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
