<?php

namespace App\Http\Controllers\Api;

use App\Models\Habit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HabitController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Habit::query()->with(['days', 'logs']);

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        return response()->json([
            'data' => $query->paginate(10)->items(),
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $habit = Habit::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return response()->json(['data' => $habit], 201);
    }

    public function update(Request $request, Habit $habit)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $habit->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $habit->update($validated);

        return response()->json(['data' => $habit]);
    }

    public function destroy(Habit $habit)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $habit->user_id !== $user->id) {
            abort(403);
        }

        $habit->delete();

        return response()->json(['message' => 'Deleted']);
    }
}

