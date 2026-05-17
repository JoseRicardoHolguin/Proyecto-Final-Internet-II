<?php

namespace App\Http\Controllers\Api;

use App\Models\Habit;
use App\Models\HabitDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitDayController extends Controller
{
    public function index(Request $request, Habit $habit)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $habit->user_id !== $user->id) {
            abort(403);
        }

        $days = $habit->days()->orderBy('day_of_week')->get();

        return response()->json([
            'data' => $days,
        ]);
    }

    public function store(Request $request, Habit $habit)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $habit->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'day_of_week' => ['required', 'integer', 'min:1', 'max:7', 'unique:habit_days,day_of_week,NULL,id,habit_id,'.$habit->id],
        ]);

        $day = $habit->days()->create([
            'day_of_week' => $validated['day_of_week'],
        ]);

        return response()->json(['data' => $day], 201);
    }

    public function destroy(Request $request, Habit $habit, HabitDay $day)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $habit->user_id !== $user->id) {
            abort(403);
        }

        if ($day->habit_id !== $habit->id) {
            abort(404);
        }

        $day->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
