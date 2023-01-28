<?php

namespace Database\Seeders\Constants;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Seed the database with all the Countries.
     *
     * @return void
     */
    public function run()
    {
        Country::factory()
            ->createMany([
                ['name' => 'Belgium', 'iso' => 'BE'],
                ['name' => 'France', 'iso' => 'FR'],
                ['name' => 'Netherlands', 'iso' => 'NL'],
                ['name' => 'Germany', 'iso' => 'DE'],
                ['name' => 'Spain', 'iso' => 'ES'],
                ['name' => 'Italy', 'iso' => 'IT'],
            ]);
    }
}
