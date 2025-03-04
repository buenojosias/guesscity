<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $places = [
            [
                'name' => 'Jardim Botânico',
                'latitude' => -25.4425348,
                'longitude' => -49.2383106,
            ],
            [
                'name' => 'Ópera de Arame',
                'latitude' => -25.385589,
                'longitude' => -49.2756492,
            ],
            [
                'name' => 'Parque Tanguá',
                'latitude' => -25.378428,
                'longitude' => -49.281660,
            ],
        ];

        foreach ($places as $place) {
            \App\Models\Place::create($place);
        }
    }
}
