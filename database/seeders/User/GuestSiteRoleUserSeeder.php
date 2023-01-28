<?php

namespace Database\Seeders\User;

use App\Models\SiteRole;

class GuestSiteRoleUserSeeder extends SiteRoleUserSeeder
{
    /**
     * Seeder to create a guest user.
     */
    public function __construct()
    {
        parent::__construct('guest', SiteRole::GUEST);
    }
}
