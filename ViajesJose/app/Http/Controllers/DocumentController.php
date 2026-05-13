<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Travel;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $travelId = $request->query('travel_id');
        $documents = $travelId ? Document::where('travel_id', $travelId)->get() : Document::with('travel')->get();
        return view('documents.index', compact('documents', 'travelId'));
    }

    public function create(Request $request)
    {
        $travels = Travel::pluck('name', 'id');
        $travelId = $request->query('travel_id');
        return view('documents.create', compact('travels', 'travelId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'travel_id' => 'required|exists:travels,id',
            'name' => 'required|string|max:255',
            'file_path' => 'nullable|string|max:500',
            'required' => 'boolean',
        ]);

        Document::create($validated);
        return redirect()->route('documents.index')->with('success', 'Documento creado');
    }

    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    public function edit(Document $document)
    {
        $travels = Travel::pluck('name', 'id');
        return view('documents.edit', compact('document', 'travels'));
    }

    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'travel_id' => 'required|exists:travels,id',
            'name' => 'required|string|max:255',
            'file_path' => 'nullable|string|max:500',
            'required' => 'boolean',
        ]);

        $document->update($validated);
        return redirect()->route('documents.show', $document)->with('success', 'Documento actualizado');
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Documento eliminado');
    }
}
