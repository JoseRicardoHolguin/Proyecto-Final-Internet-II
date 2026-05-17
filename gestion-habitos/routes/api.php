<?php

use App\Http\Controllers\Api\HabitController as ApiHabitController;
use App\Http\Controllers\Api\HabitDayController as ApiHabitDayController;
use App\Http\Controllers\Api\HabitLogController as ApiHabitLogController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::post('/tokens/create', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
        'device_name' => ['required', 'string'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }

    $token = $user->createToken($request->device_name)->plainTextToken;

    return response()->json(['token' => $token]);
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Habits endpoints
    Route::get('/habits', [ApiHabitController::class, 'index']);
    Route::post('/habits', [ApiHabitController::class, 'store']);
    Route::put('/habits/{habit}', [ApiHabitController::class, 'update']);
    Route::delete('/habits/{habit}', [ApiHabitController::class, 'destroy']);

    // Habit Days endpoints
    Route::get('/habits/{habit}/days', [ApiHabitDayController::class, 'index']);
    Route::post('/habits/{habit}/days', [ApiHabitDayController::class, 'store']);
    Route::delete('/habits/{habit}/days/{day}', [ApiHabitDayController::class, 'destroy']);

    // Habit Logs endpoints
    Route::get('/habits/{habit}/logs', [ApiHabitLogController::class, 'index']);
    Route::post('/habits/{habit}/logs', [ApiHabitLogController::class, 'store']);
    Route::delete('/logs/{log}', [ApiHabitLogController::class, 'destroy']);
});

