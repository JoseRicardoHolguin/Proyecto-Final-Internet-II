<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        $query = Document::with('travel');
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
            'file_path' => 'nullable|string|max:500',
            'required' => 'boolean',
        ]);

        $document = Document::create($validated);
        return response()->json($document, 201);
    }

    public function show(Document $document)
    {
        return response()->json($document->load('travel'));
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
        return response()->json($document);
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return response()->json(['message' => 'Documento eliminado']);
    }
}
