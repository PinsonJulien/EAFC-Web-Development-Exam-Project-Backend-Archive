<?php

namespace Database\Seeders\User;

use App\Models\SiteRole;

class AdministratorSiteRoleUserSeeder extends SiteRoleUserSeeder
{
    /**
     * Seeder to create a administrator user.
     */
    public function __construct()
    {
        parent::__construct('administrator', SiteRole::ADMINISTRATOR);
    }
}
