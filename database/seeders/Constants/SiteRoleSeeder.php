<?php

namespace Database\Seeders\Constants;

use App\Models\SiteRole;
use Illuminate\Database\Seeder;

class SiteRoleSeeder extends Seeder
{
    /**
     * Seed the database with all the Site Roles
     *
     * @return void
     */
    public function run(): void
    {
        SiteRole::insert(
            [
                ['name' => 'guest', 'id' => 1],
                ['name' => 'user', 'id' => 2],
                ['name' => 'secretary', 'id' => 3],
                ['name' => 'administrator', 'id' => 4],
                ['name' => 'banned', 'id' => 5],
            ]
        );
    }
}
