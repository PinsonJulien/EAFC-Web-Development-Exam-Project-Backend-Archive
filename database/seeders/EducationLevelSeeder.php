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
        $levels = [
            'Master',
            'Bac',
            'BES',
            'DS',
            'DI',
        ];

        foreach($levels as $level) {
            EducationLevel::create(['name' => $level]);
        }
    }
}
