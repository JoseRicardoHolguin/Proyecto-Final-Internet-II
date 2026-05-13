<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Place::with('travel');
        if ($request->travel_id) {
            $query->where('travel_id', $request->travel_id);
        }
        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'travel_id' => 'required|exists:travels,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $place = Place::create($validated);
        return response()->json($place, 201);
    }

    public function show(Place $place)
    {
        return response()->json($place->load('travel'));
    }

    public function update(Request $request, Place $place)
    {
        $validated = $request->validate([
            'travel_id' => 'required|exists:travels,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $place->update($validated);
        return response()->json($place);
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return response()->json(['message' => 'Lugar eliminado']);
    }
}
