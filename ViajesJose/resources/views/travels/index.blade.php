@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-4">Viajes</h1>
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    <a href="{{ route('travels.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Nuevo Viaje</a>
    <table class="w-full mt-4 border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Fecha Inicio</th>
                <th class="px-4 py-2">Fecha Fin</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($travels as $travel)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $travel->name }}</td>
                    <td class="px-4 py-2">{{ $travel->start_date }}</td>
                    <td class="px-4 py-2">{{ $travel->end_date }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('travels.show', $travel) }}" class="text-blue-600">Ver</a>
                        <a href="{{ route('travels.edit', $travel) }}" class="text-green-600 ml-2">Editar</a>
                        <form action="{{ route('travels.destroy', $travel) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 ml-2" onclick="return confirm('¿Eliminar viaje?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-2 text-center">No hay viajes.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
