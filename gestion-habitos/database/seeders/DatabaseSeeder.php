<?php

namespace Database\Seeders;

use App\Models\Habit;
use App\Models\HabitDay;
use App\Models\HabitLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 2 usuarios para cubrir roles: uno admin y otro usuario.
        // Si ya existen (por re-seed), los usamos en vez de duplicar el email.
        $adminUser = User::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'role' => 'admin',
                // Requerido por la migración de users.password
                'password' => bcrypt('admin1234'),
            ]
        );

        $normalUser = User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'role' => 'usuario',
                // Requerido por la migración de users.password
                'password' => bcrypt('test1234'),
            ]
        );


        $user = $normalUser;


        // 10 habits para usuario normal + 5 para admin
        Habit::query()->delete();

        $habits = collect();
        
        // Crear 10 hábitos para usuario normal
        for ($i = 1; $i <= 10; $i++) {
            $habits->push(
                Habit::create([
                    'user_id' => $normalUser->id,
                    'title' => 'Habit '.$i,
                    'description' => 'Description for habit '.$i,
                    'is_active' => true,
                ])
            );
        }

        // Crear 5 hábitos para admin
        for ($i = 11; $i <= 15; $i++) {
            Habit::create([
                'user_id' => $adminUser->id,
                'title' => 'Habit Admin '.$i,
                'description' => 'Admin habit description '.$i,
                'is_active' => true,
            ]);
        }

        // 10 habit_days (sin romper el unique [habit_id, day_of_week])
        // Repartimos 10 días entre los habits para que no se repita day_of_week dentro del mismo habit.
        $daysPerHabit = [
            0 => [1, 2],
            1 => [3, 4],
            2 => [5, 6],
            3 => [7, 1],
            4 => [2, 3],
            5 => [4, 5],
            6 => [6, 7],
            7 => [1, 2],
            8 => [3, 4],
            9 => [5, 6],
        ];

        $createdHabitDays = 0;
        foreach ($habits as $index => $habit) {
            if ($createdHabitDays >= 10) {
                break;
            }

            foreach (($daysPerHabit[$index] ?? []) as $dayOfWeek) {
                if ($createdHabitDays >= 10) {
                    break;
                }

                HabitDay::create([
                    'habit_id' => $habit->id,
                    'day_of_week' => $dayOfWeek, // 1..7
                ]);

                $createdHabitDays++;
            }
        }

        // 10 habit_logs (sin romper el unique [habit_id, user_id, log_date])
        // Usamos 10 fechas distintas.
        $start = now()->subDays(9)->toDateString();
        for ($i = 0; $i < 10; $i++) {
            $logDate = now()->subDays(9 - $i)->toDateString();

            HabitLog::create([
                'habit_id' => $habits[$i % 10]->id,
                'user_id' => $normalUser->id,
                'log_date' => $logDate,
                'completed_at' => ($i % 2 === 0) ? now() : null,
            ]);
        }
    }
}

