<?php

namespace Database\Seeders;

use App\Models\SiteRole;
use Illuminate\Database\Seeder;

class SiteRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteRole::insert(
            [
                ['name' => 'user', 'id' => 1],
                ['name' => 'secretary', 'id' => 2],
                ['name' => 'administrator', 'id' => 3],
            ]
        );
    }
}
