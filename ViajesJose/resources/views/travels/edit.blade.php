@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-4">Editar Viaje</h1>
    <form method="POST" action="{{ route('travels.update', $travel) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block mb-1">Nombre</label>
            <input type="text" name="name" value="{{ $travel->name }}" class="border p-2 w-full" required>
            @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Fecha Inicio</label>
            <input type="date" name="start_date" value="{{ $travel->start_date }}" class="border p-2 w-full" required>
            @error('start_date') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1">Fecha Fin</label>
            <input type="date" name="end_date" value="{{ $travel->end_date }}" class="border p-2 w-full" required>
            @error('end_date') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
        <a href="{{ route('travels.index') }}" class="text-gray-600 ml-4">Cancelar</a>
    </form>
</div>
@endsection
