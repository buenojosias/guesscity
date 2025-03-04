<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $country = Country::create([
            'name' => 'Brasil',
            'abbreviation' => 'BR',
        ]);

        $state = $country->states()->create([
            'name' => 'Paraná',
            'abbreviation' => 'PR',
        ]);

        $state->cities()->create([
            'name' => 'Curitiba',
            'latitude' => -25.4295963,
            'longitude' => -49.2712724,
            'neighbors' => [],
        ]);
    }
}
