<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $travels = [
            ['user_id' => 1, 'name' => 'Viaje a París', 'start_date' => '2024-06-01', 'end_date' => '2024-06-10'],
            ['user_id' => 1, 'name' => 'Viaje a Roma', 'start_date' => '2024-07-15', 'end_date' => '2024-07-22'],
            ['user_id' => 1, 'name' => 'Viaje a Barcelona', 'start_date' => '2024-08-05', 'end_date' => '2024-08-12'],
            ['user_id' => 2, 'name' => 'Viaje a México DF', 'start_date' => '2024-05-10', 'end_date' => '2024-05-17'],
            ['user_id' => 2, 'name' => 'Viaje a Cancún', 'start_date' => '2024-09-01', 'end_date' => '2024-09-07'],
            ['user_id' => 2, 'name' => 'Viaje a Guadalajara', 'start_date' => '2024-10-20', 'end_date' => '2024-10-25'],
            ['user_id' => 3, 'name' => 'Viaje a Nueva York', 'start_date' => '2024-04-12', 'end_date' => '2024-04-20'],
            ['user_id' => 3, 'name' => 'Viaje a Los Ángeles', 'start_date' => '2024-11-05', 'end_date' => '2024-11-15'],
            ['user_id' => 1, 'name' => 'Viaje a Tokio', 'start_date' => '2025-01-10', 'end_date' => '2025-01-25'],
            ['user_id' => 2, 'name' => 'Viaje aLondres', 'start_date' => '2025-02-14', 'end_date' => '2025-02-21'],
        ];

        foreach ($travels as $travel) {
            \App\Models\Travel::create($travel);
        }
    }
}
