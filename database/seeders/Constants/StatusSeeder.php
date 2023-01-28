<?php

namespace Database\Seeders\Constants;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Seed the database with all the Statuses.
     *
     * @return void
     */
    public function run(): void
    {
        Status::insert(
            [
                ['name' => 'pending',   'id' => 1],
                ['name' => 'approved',  'id' => 2],
                ['name' => 'denied',    'id' => 3],
                ['name' => 'cancelled', 'id' => 4],
                ['name' => 'expired',   'id' => 5],
                ['name' => 'suspended', 'id' => 6],
            ]
        );
    }
}
