<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HabitDayController extends Controller
{
    public function index(Habit $habit): View
    {
        if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
            abort(403);
        }

        $days = $habit->days()->orderBy('day_of_week')->get();

        return view('habit_days.index', compact('habit', 'days'));
    }

    public function store(Request $request, Habit $habit)
    {
        if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'day_of_week' => ['required', 'integer', 'min:1', 'max:7', 'unique:habit_days,day_of_week,NULL,id,habit_id,'.$habit->id],
        ], [
            'day_of_week.unique' => 'Este día ya está configurado para este hábito.',
            'day_of_week.min' => 'El día debe ser entre 1 (Lunes) y 7 (Domingo).',
            'day_of_week.max' => 'El día debe ser entre 1 (Lunes) y 7 (Domingo).',
        ]);

        $habit->days()->create([
            'day_of_week' => $validated['day_of_week'],
        ]);

        return redirect()->route('habits.days.index', $habit)->with('status', 'Día agregado correctamente');
    }

    public function destroy(Habit $habit, HabitDay $day)
    {
        if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
            abort(403);
        }

        $day->delete();

        return redirect()->route('habits.days.index', $habit)->with('status', 'Día eliminado');
    }
}

