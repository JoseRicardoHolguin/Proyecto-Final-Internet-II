@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-4">Lugares Visitados</h1>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <a href="{{ route('places.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Nuevo Lugar</a>
    <table class="w-full mt-4 border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Descripción</th>
                <th class="px-4 py-2">Viaje</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($places as $place)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $place->name }}</td>
                    <td class="px-4 py-2">{{ $place->description }}</td>
                    <td class="px-4 py-2">{{ $place->travel->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('places.show', $place) }}" class="text-blue-600">Ver</a>
                        <a href="{{ route('places.edit', $place) }}" class="text-green-600 ml-2">Editar</a>
                        <form action="{{ route('places.destroy', $place) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 ml-2" onclick="return confirm('¿Eliminar lugar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-2 text-center">No hay lugares.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
