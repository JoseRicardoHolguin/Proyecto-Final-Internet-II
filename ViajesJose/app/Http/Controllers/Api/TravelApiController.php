<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelApiController extends Controller
{
    public function index()
    {
        $travels = Travel::with(['places', 'documents'])->where('user_id', Auth::id())->get();
        return response()->json($travels);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $travel = Auth::user()->travels()->create($validated);
        return response()->json($travel, 201);
    }

    public function show(Travel $travel)
    {
        $travel->load(['places', 'documents']);
        return response()->json($travel);
    }

    public function update(Request $request, Travel $travel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $travel->update($validated);
        return response()->json($travel);
    }

    public function destroy(Travel $travel)
    {
        $travel->delete();
        return response()->json(['message' => 'Viaje eliminado']);
    }
}
