<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mis hábitos</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
            @endif

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Mis hábitos</h3>
                    <p class="text-sm text-gray-600 mt-1">Gestiona tus hábitos diarios</p>
                </div>
                <a href="{{ route('habits.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 font-medium">+ Nuevo hábito</a>
            </div>

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left border-b bg-gray-50">
                                    <th class="py-3 px-4">Título</th>
                                    <th class="py-3 px-4">Descripción</th>
                                    <th class="py-3 px-4 text-center">Días</th>
                                    <th class="py-3 px-4 text-center">Logs</th>
                                    <th class="py-3 px-4">Estado</th>
                                    <th class="py-3 px-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($habits as $habit)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4 font-medium text-gray-900">{{ $habit->title }}</td>
                                        <td class="py-3 px-4 text-gray-600">{{ Str::limit($habit->description, 40) ?? '—' }}</td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $habit->days_count ?? $habit->days->count() }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $habit->logs_count ?? $habit->logs->count() }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($habit->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 space-x-2 text-sm">
                                            <a href="{{ route('habits.edit', $habit) }}" class="text-indigo-700 underline hover:text-indigo-900">Editar</a>
                                            <a href="{{ route('habits.days.index', $habit) }}" class="text-blue-700 underline hover:text-blue-900">Días</a>
                                            <a href="{{ route('habits.logs.index', $habit) }}" class="text-purple-700 underline hover:text-purple-900">Logs</a>
                                            <form method="POST" action="{{ route('habits.destroy', $habit) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-700 underline hover:text-red-900" type="submit" onclick="return confirm('¿Eliminar hábito y todos sus datos?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if($habits->isEmpty())
                            <div class="p-6 text-center text-gray-500">
                                <p class="mb-4">No hay hábitos para mostrar.</p>
                                <a href="{{ route('habits.create') }}" class="text-indigo-600 underline">Crea tu primer hábito →</a>
                            </div>
                        @endif
                    </div>

                    @if($habits->hasPages())
                        <div class="mt-6 border-t pt-6">
                            {{ $habits->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

