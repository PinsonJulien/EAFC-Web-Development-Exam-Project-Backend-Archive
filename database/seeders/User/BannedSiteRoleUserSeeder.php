<?php

namespace Database\Seeders\User;

use App\Models\SiteRole;

class BannedSiteRoleUserSeeder extends SiteRoleUserSeeder
{
    /**
     * Seeder to create a administrator user.
     */
    public function __construct()
    {
        parent::__construct('banned', SiteRole::BANNED);
    }
}
