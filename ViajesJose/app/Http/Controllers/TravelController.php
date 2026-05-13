<?php

namespace App\Http\Controllers;

use App\Models\Travel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $travels = Travel::with(['user', 'places', 'documents'])->get();
        } else {
            $travels = Travel::with(['places', 'documents'])->where('user_id', Auth::id())->get();
        }
        return view('travels.index', compact('travels'));
    }

    public function create()
    {
        return view('travels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Auth::user()->travels()->create($validated);
        return redirect()->route('travels.index')->with('success', 'Viaje creado');
    }

    public function show(Travel $travel)
    {
        $this->authorizeTravel($travel);
        $travel->load(['places', 'documents']);
        return view('travels.show', compact('travel'));
    }

    public function edit(Travel $travel)
    {
        $this->authorizeTravel($travel);
        return view('travels.edit', compact('travel'));
    }

    public function update(Request $request, Travel $travel)
    {
        $this->authorizeTravel($travel);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $travel->update($validated);
        return redirect()->route('travels.show', $travel)->with('success', 'Viaje actualizado');
    }

    public function destroy(Travel $travel)
    {
        $this->authorizeTravel($travel);
        $travel->delete();
        return redirect()->route('travels.index')->with('success', 'Viaje eliminado');
    }

    private function authorizeTravel(Travel $travel)
    {
        if (Auth::user()->role !== 'admin' && $travel->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
