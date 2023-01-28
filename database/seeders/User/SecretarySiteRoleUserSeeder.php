<?php

namespace Database\Seeders\User;

use App\Models\SiteRole;

class SecretarySiteRoleUserSeeder extends SiteRoleUserSeeder
{
    /**
     * Seeder to create a Secretary user.
     */
    public function __construct()
    {
        parent::__construct('secretary', SiteRole::SECRETARY);
    }
}
