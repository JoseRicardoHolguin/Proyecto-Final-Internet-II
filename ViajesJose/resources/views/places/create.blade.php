@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-4">Nuevo Lugar</h1>
    <form method="POST" action="{{ route('places.store') }}" class="max-w-md">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Nombre del Lugar</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
            @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Descripción</label>
            <textarea name="description" class="w-full border p-2 rounded" required></textarea>
            @error('description') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Viaje</label>
            <select name="travel_id" class="w-full border p-2 rounded" required>
                @foreach($travels as $travel)
                    <option value="{{ $travel->id }}">{{ $travel->name }}</option>
                @endforeach
            </select>
            @error('travel_id') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Latitud</label>
            <input type="text" name="latitude" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Longitud</label>
            <input type="text" name="longitude" class="w-full border p-2 rounded">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('places.index') }}" class="ml-4 text-gray-600">Cancelar</a>
    </form>
</div>
@endsection
