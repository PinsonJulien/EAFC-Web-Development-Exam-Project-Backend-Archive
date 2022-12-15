<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::factory()
            ->count(25)
            ->create();

        /*Country::insert(
            [
                ['name' => 'Belgium', 'iso' => 'BE'],
                ['name' => 'France', 'iso' => 'FR'],
                ['name' => 'Netherlands', 'iso' => 'NL'],
                ['name' => 'Germany', 'iso' => 'DE'],
                ['name' => 'Spain', 'iso' => 'ES'],
            ]
        );*/
    }
}
