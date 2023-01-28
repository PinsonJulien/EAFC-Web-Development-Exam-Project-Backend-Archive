<?php

namespace Database\Seeders;

use Database\Seeders\Constants\ConstantSeeder;
use Database\Seeders\Constants\CountrySeeder;
use Database\Seeders\Faked\CohortMemberSeeder;
use Database\Seeders\Faked\CohortSeeder;
use Database\Seeders\Faked\EnrollmentSeeder;
use Database\Seeders\Faked\FormationSeeder;
use Database\Seeders\Faked\GradeSeeder;
use Database\Seeders\Faked\UserSeeder;
use Database\Seeders\User\AdministratorSiteRoleUserSeeder;
use Database\Seeders\User\BannedSiteRoleUserSeeder;
use Database\Seeders\User\GuestSiteRoleUserSeeder;
use Database\Seeders\User\SecretarySiteRoleUserSeeder;
use Database\Seeders\User\UserSiteRoleUserSeeder;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Seed the database with fake data for demo purpose.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            // constants
            ConstantSeeder::class,

            // Generate accounts with all the SiteRoles.
            AdministratorSiteRoleUserSeeder::class,
            SecretarySiteRoleUserSeeder::class,
            UserSiteRoleUserSeeder::class,
            GuestSiteRoleUserSeeder::class,
            BannedSiteRoleUserSeeder::class,

            // Fake data
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
