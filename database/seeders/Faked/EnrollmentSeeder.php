<?php

namespace Database\Seeders\Faked;

use App\Models\Enrollment;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Enrollment::factory()
            ->count(20)
            ->create();
    }
}
