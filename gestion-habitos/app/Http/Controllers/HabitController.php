<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HabitController extends Controller
{
    public function index(): View
    {
        $query = Habit::query()->with(['days', 'logs']);

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $habits = $query->paginate(10);

        return view('habits.index', compact('habits'));
    }

    public function create(): View
    {
        $habit = new Habit();
        return view('habits.form', compact('habit'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_active'] = $validated['is_active'] ?? true;

        $habit = Habit::create($validated);

        return redirect()->route('habits.edit', $habit)->with('status', 'Habit creada');
    }

    public function edit(Habit $habit): View
    {
        if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
            abort(403);
        }

        return view('habits.form', compact('habit'));
    }

    public function update(Request $request, Habit $habit)
    {
        if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $validated['is_active'] ?? false;

        $habit->update($validated);

        return redirect()->route('habits.edit', $habit)->with('status', 'Habit actualizada');
    }

    public function destroy(Habit $habit)
    {
        if (Auth::user()->role !== 'admin' && $habit->user_id !== Auth::id()) {
            abort(403);
        }

        $habit->delete();

        return redirect()->route('habits.index')->with('status', 'Habit eliminada');
    }
}

