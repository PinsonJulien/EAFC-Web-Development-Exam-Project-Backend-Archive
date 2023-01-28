<?php

namespace Database\Seeders;

use Database\Seeders\Constants\ConstantSeeder;
use Database\Seeders\User\AdministratorSiteRoleUserSeeder;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Seed the database with fake data for the production environment.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // constants
            ConstantSeeder::class,

            // Default administrator
            AdministratorSiteRoleUserSeeder::class,
        ]);
    }
}
