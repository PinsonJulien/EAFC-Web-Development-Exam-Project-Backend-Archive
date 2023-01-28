<?php

namespace Database\Seeders\User;

use App\Models\SiteRole;

class UserSiteRoleUserSeeder extends SiteRoleUserSeeder
{
    /**
     * Seeder to create a User user.
     */
    public function __construct()
    {
        parent::__construct('user', SiteRole::USER);
    }
}
