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
                ['name' => 'guest', 'id' => 1],
                ['name' => 'user', 'id' => 2],
                ['name' => 'secretary', 'id' => 3],
                ['name' => 'administrator', 'id' => 4],
            ]
        );
    }
}
