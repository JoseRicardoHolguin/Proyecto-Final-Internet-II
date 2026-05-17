<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Models\Habit;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();

    // Admin: ve logs globales; usuario normal: solo logs del usuario autenticado.
    $isAdmin = ($user?->role === 'admin');
    
    // Construir query de habits
    $habitQuery = Habit::query()->with(['days']);

    if ($isAdmin) {
        // Admin ve todos los hábitos
        $habitQuery->with(['logs']);
    } else {
        // Usuario normal ve solo sus hábitos con sus logs
        $habitQuery->where('user_id', $user->id)
                   ->with(['logs' => fn ($q) => $q->where('user_id', $user->id)]);
    }

    $habits = $habitQuery->orderByDesc('id')
                         ->limit(10)
                         ->get();

    return view('dashboard', [
        'habits' => $habits,
        'isAdmin' => $isAdmin,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
