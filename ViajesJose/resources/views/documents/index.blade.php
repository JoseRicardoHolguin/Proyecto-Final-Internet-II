@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-4">Documentación</h1>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <a href="{{ route('documents.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Nuevo Documento</a>
    <table class="w-full mt-4 border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Viaje</th>
                <th class="px-4 py-2">Requerido</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $doc)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $doc->name }}</td>
                    <td class="px-4 py-2">{{ $doc->travel->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">{{ $doc->required ? 'Sí' : 'No' }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('documents.show', $doc) }}" class="text-blue-600">Ver</a>
                        <a href="{{ route('documents.edit', $doc) }}" class="text-green-600 ml-2">Editar</a>
                        <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 ml-2" onclick="return confirm('¿Eliminar documento?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-2 text-center">No hay documentos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
