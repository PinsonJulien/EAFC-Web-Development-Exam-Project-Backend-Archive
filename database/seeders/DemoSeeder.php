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
            // constants
            SiteRoleSeeder::class,
            CohortRoleSeeder::class,
            EducationLevelSeeder::class,

            // Administrator
            // todo

            // Fake data for demo purpose.
            CountrySeeder::class,
            UserSeeder::class,
            FormationSeeder::class,
            CohortSeeder::class,
            CohortMemberSeeder::class,
        ]);
    }
}
