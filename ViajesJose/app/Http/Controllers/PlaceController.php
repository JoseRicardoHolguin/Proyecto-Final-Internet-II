<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        $travelId = $request->query('travel_id');
        $places = $travelId ? Place::where('travel_id', $travelId)->get() : Place::with('travel')->get();
        return view('places.index', compact('places', 'travelId'));
    }

    public function create(Request $request)
    {
        $travels = Travel::pluck('name', 'id');
        $travelId = $request->query('travel_id');
        return view('places.create', compact('travels', 'travelId'));
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

        Place::create($validated);
        return redirect()->route('places.index')->with('success', 'Lugar creado');
    }

    public function show(Place $place)
    {
        return view('places.show', compact('place'));
    }

    public function edit(Place $place)
    {
        $travels = Travel::pluck('name', 'id');
        return view('places.edit', compact('place', 'travels'));
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
        return redirect()->route('places.show', $place)->with('success', 'Lugar actualizado');
    }

    public function destroy(Place $place)
    {
        $place->delete();
        return redirect()->route('places.index')->with('success', 'Lugar eliminado');
    }
}
