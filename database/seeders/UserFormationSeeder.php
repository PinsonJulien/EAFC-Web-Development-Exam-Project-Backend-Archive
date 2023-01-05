<?php

namespace Database\Seeders;

use App\Models\UserFormation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserFormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserFormation::factory()
            ->times(10)
            ->create();
    }
}
