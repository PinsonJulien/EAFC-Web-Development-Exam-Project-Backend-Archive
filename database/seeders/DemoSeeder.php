<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            EducationLevelSeeder::class,

            UserSeeder::class,
            FormationSeeder::class,
        ]);
    }
}
