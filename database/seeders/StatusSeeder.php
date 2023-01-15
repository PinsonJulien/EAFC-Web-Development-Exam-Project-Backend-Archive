<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
