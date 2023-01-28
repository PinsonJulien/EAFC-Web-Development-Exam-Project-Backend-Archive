<?php

namespace Database\Seeders\Constants;

use Illuminate\Database\Seeder;

class ConstantSeeder extends Seeder
{
    /**
     * Seed the database with all the constants tables.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            SiteRoleSeeder::class,
            CohortRoleSeeder::class,
            EducationLevelSeeder::class,
            StatusSeeder::class,
            CountrySeeder::class,
        ]);
    }
}
