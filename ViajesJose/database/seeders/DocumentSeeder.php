<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $documents = [
            ['travel_id' => 1, 'name' => 'Pasaporte', 'file_path' => '/documents/pasaporte.pdf', 'required' => true],
            ['travel_id' => 1, 'name' => 'Visa Francia', 'file_path' => '/documents/visa_francia.pdf', 'required' => true],
            ['travel_id' => 1, 'name' => 'Boletos', 'file_path' => '/documents/boletos.pdf', 'required' => true],
            ['travel_id' => 2, 'name' => 'Pasaporte', 'file_path' => '/documents/pasaporte2.pdf', 'required' => true],
            ['travel_id' => 2, 'name' => 'Visa Italia', 'file_path' => '/documents/visa_italia.pdf', 'required' => true],
            ['travel_id' => 3, 'name' => 'Pasaporte', 'file_path' => '/documents/pasaporte3.pdf', 'required' => true],
            ['travel_id' => 4, 'name' => 'INE', 'file_path' => '/documents/ine.pdf', 'required' => true],
            ['travel_id' => 5, 'name' => 'Reservación Hotel', 'file_path' => '/documents/hotel.pdf', 'required' => true],
            ['travel_id' => 6, 'name' => 'Boletos Avión', 'file_path' => '/documents/boletos_gdl.pdf', 'required' => true],
            ['travel_id' => 7, 'name' => 'Pasaporte USA', 'file_path' => '/documents/pasaporte_usa.pdf', 'required' => true],
            ['travel_id' => 8, 'name' => 'Visa USA', 'file_path' => '/documents/visa_usa.pdf', 'required' => true],
            ['travel_id' => 9, 'name' => 'Pasaporte Japón', 'file_path' => '/documents/pasaporte_jp.pdf', 'required' => true],
            ['travel_id' => 10, 'name' => 'Pasaporte UK', 'file_path' => '/documents/pasaporte_uk.pdf', 'required' => true],
        ];

        foreach ($documents as $doc) {
            \App\Models\Document::create($doc);
        }
    }
}
