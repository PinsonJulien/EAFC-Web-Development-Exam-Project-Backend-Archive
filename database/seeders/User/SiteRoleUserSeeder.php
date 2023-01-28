<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Seeder;

abstract class SiteRoleUserSeeder extends Seeder
{
    protected string $roleName;
    protected int $roleId;

    public function __construct(string $roleName, int $roleId)
    {
        $this->roleName = $roleName;
        $this->roleId = $roleId;
    }

    /**
     * Generates a User with a specific role.
     * Usage : Test purposes, default administrator on first deployment.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'username' => $this->roleName,
            'email' => $this->roleName.'@site.com',
            'password' => bcrypt($this->roleName),
            'site_role_id' => $this->roleId,
        ]);
    }
}
