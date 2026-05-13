<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $places = [
            ['travel_id' => 1, 'name' => 'Torre Eiffel', 'description' => 'Icono de París', 'latitude' => 48.8584, 'longitude' => 2.2945],
            ['travel_id' => 1, 'name' => 'Louvre', 'description' => 'Museo famoso', 'latitude' => 48.8606, 'longitude' => 2.3376],
            ['travel_id' => 1, 'name' => 'Notre Dame', 'description' => 'Catedral histórica', 'latitude' => 48.8530, 'longitude' => 2.3499],
            ['travel_id' => 2, 'name' => 'Coliseo', 'description' => 'Anfiteatro romano', 'latitude' => 41.8902, 'longitude' => 12.4922],
            ['travel_id' => 2, 'name' => 'Vaticano', 'description' => 'Ciudad del Vaticano', 'latitude' => 41.9029, 'longitude' => 12.4534],
            ['travel_id' => 3, 'name' => 'Sagrada Familia', 'description' => ' Basilica de Gaudí', 'latitude' => 41.4036, 'longitude' => 2.1744],
            ['travel_id' => 4, 'name' => 'Zócalo', 'description' => 'Plaza principal de CDMX', 'latitude' => 19.4326, 'longitude' => -99.1332],
            ['travel_id' => 5, 'name' => 'Playa Delfines', 'description' => 'Playa pública', 'latitude' => 21.0365, 'longitude' => -86.7791],
            ['travel_id' => 6, 'name' => 'Centro Histórico', 'description' => 'Zona patrimonial', 'latitude' => 20.6597, 'longitude' => -103.3496],
            ['travel_id' => 7, 'name' => 'Times Square', 'description' => 'Zona de espectáculos', 'latitude' => 40.7580, 'longitude' => -73.9855],
            ['travel_id' => 7, 'name' => 'Estatua Libertad', 'description' => 'Monumento icónico', 'latitude' => 40.6892, 'longitude' => -74.0445],
            ['travel_id' => 8, 'name' => 'Hollywood', 'description' => 'Centro del cine', 'latitude' => 34.0928, 'longitude' => -118.3287],
            ['travel_id' => 9, 'name' => 'Torre Tokio', 'description' => 'Torre de comunicaciones', 'latitude' => 35.6586, 'longitude' => 139.7454],
            ['travel_id' => 10, 'name' => 'Big Ben', 'description' => 'Torre del reloj', 'latitude' => 51.5007, 'longitude' => -0.1246],
        ];

        foreach ($places as $place) {
            \App\Models\Place::create($place);
        }
    }
}
