<?php

namespace App\Http\Controllers\Api;

use App\Models\Habit;
use App\Models\HabitLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HabitLogController extends Controller
{
    public function index(Request $request, Habit $habit)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $habit->user_id !== $user->id) {
            abort(403);
        }

        $query = $habit->logs()->orderByDesc('log_date');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        return response()->json([
            'data' => $query->paginate(10)->items(),
        ]);
    }

    public function store(Request $request, Habit $habit)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $habit->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'log_date' => ['required', 'date'],
            'completed' => ['required', 'boolean'],
        ]);

        $completedAt = $validated['completed'] ? Carbon::now() : null;

        $log = $habit->logs()->updateOrCreate(
            [
                'user_id' => $user->id,
                'log_date' => $validated['log_date'],
            ],
            [
                'completed_at' => $completedAt,
            ]
        );

        return response()->json(['data' => $log], 201);
    }

    public function destroy(Request $request, HabitLog $log)
    {
        $user = Auth::user();

        $habit = $log->habit;

        if ($user->role !== 'admin' && $habit->user_id !== $user->id) {
            abort(403);
        }

        if ($user->role !== 'admin' && $log->user_id !== $user->id) {
            abort(403);
        }

        $log->delete();

        return response()->json(['message' => 'Deleted']);
    }
}

