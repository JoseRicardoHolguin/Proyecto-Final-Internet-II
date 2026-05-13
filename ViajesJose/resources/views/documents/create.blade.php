@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-4">Nuevo Documento</h1>
    <form method="POST" action="{{ route('documents.store') }}" class="max-w-md">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Nombre del Documento</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
            @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Viaje</label>
            <select name="travel_id" class="w-full border p-2 rounded" required>
                @foreach($travels as $travel)
                    <option value="{{ $travel->id }}">{{ $travel->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Ruta del Archivo</label>
            <input type="text" name="file_path" class="w-full border p-2 rounded" placeholder="/documents/archivo.pdf">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">
                <input type="checkbox" name="required" value="1"> Requerido
            </label>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('documents.index') }}" class="ml-4 text-gray-600">Cancelar</a>
    </form>
</div>
@endsection
