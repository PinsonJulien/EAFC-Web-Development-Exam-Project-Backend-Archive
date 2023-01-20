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
            StatusSeeder::class,

            // todo Administrator
            // todo also add users for each roles, they have the role as their username.

            // Fake data for demo purpose.
            CountrySeeder::class,
            UserSeeder::class,
            FormationSeeder::class,
            CohortSeeder::class,
            CohortMemberSeeder::class,
            EnrollmentSeeder::class,
            GradeSeeder::class,
        ]);
    }
}
