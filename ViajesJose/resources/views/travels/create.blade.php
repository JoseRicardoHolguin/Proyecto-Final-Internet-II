@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-4">Nuevo Viaje</h1>
    <form method="POST" action="{{ route('travels.store') }}" class="max-w-md">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Nombre del Viaje</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
            @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Fecha Inicio</label>
            <input type="date" name="start_date" class="w-full border p-2 rounded" required>
            @error('start_date') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Fecha Fin</label>
            <input type="date" name="end_date" class="w-full border p-2 rounded" required>
            @error('end_date') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('travels.index') }}" class="ml-4 text-gray-600">Cancelar</a>
    </form>
</div>
@endsection
