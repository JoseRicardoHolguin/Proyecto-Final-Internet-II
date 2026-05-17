<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HabitLogController extends Controller
{
    public function index(Habit $habit): View
    {
        if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
            abort(403);
        }

        $query = $habit->logs()->with('user')->orderByDesc('log_date');

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $logs = $query->paginate(10);

        return view('habit_logs.index', compact('habit', 'logs'));
    }

    public function store(Request $request, Habit $habit)
    {
        if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'log_date' => ['required', 'date', 'date_format:Y-m-d'],
            'completed' => ['required', 'boolean'],
        ], [
            'log_date.date' => 'Debe proporcionar una fecha válida.',
            'log_date.date_format' => 'El formato de fecha debe ser YYYY-MM-DD.',
            'completed.required' => 'Debe indicar si se completó o no.',
        ]);

        $userId = Auth::id();

        $completedAt = $validated['completed'] ? Carbon::now() : null;

        $log = $habit->logs()->updateOrCreate(
            [
                'user_id' => $userId,
                'log_date' => $validated['log_date'],
            ],
            [
                'completed_at' => $completedAt,
            ]
        );

        $action = $log->wasRecentlyCreated ? 'creado' : 'actualizado';
        return redirect()->route('habits.logs.index', $habit)->with('status', "Registro {$action} correctamente");
    }

    public function destroy(Habit $habit, HabitLog $log)
    {
        if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
            abort(403);
        }

        if (Auth::user()->role !== 'admin' && $log->user_id !== Auth::id()) {
            abort(403);
        }

        $log->delete();

        return redirect()->route('habits.logs.index', $habit)->with('status', 'Registro eliminado');
    }
}

