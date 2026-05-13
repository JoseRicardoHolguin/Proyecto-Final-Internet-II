@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto py-6 px-4">
    <h1 class="text-2xl font-bold mb-4">{{ $travel->name }}</h1>
    <p><strong>Inicio:</strong> {{ $travel->start_date }}</p>
    <p><strong>Fin:</strong> {{ $travel->end_date }}</p>
    
    <h2 class="text-xl font-bold mt-6 mb-2">Lugares Visitados</h2>
    <ul>
        @forelse($travel->places as $place)
            <li>{{ $place->name }} - {{ $place->description }}</li>
        @empty
            <li>No hay lugares registrados.</li>
        @endforelse
    </ul>
    
    <h2 class="text-xl font-bold mt-6 mb-2">Documentación</h2>
    <ul>
        @forelse($travel->documents as $doc)
            <li>{{ $doc->name }} ({{ $doc->required ? 'Requerido' : 'Opcional' }})</li>
        @empty
            <li>No hay documentos.</li>
        @endforelse
    </ul>
    
    <a href="{{ route('travels.edit', $travel) }}" class="text-blue-600 mt-4 inline-block">Editar</a>
    <a href="{{ route('travels.index') }}" class="text-gray-600 ml-4">Volver</a>
</div>
@endsection
