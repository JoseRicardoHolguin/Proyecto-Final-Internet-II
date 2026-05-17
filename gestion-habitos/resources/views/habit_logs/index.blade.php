<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Logs del hábito: {{ $habit->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 border-b pb-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Registrar nuevo log</h3>
                        <form method="POST" action="{{ route('habits.logs.store', $habit) }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @csrf
                            <div>
                                <x-input-label for="log_date" :value="__('Fecha del registro')" />
                                <x-text-input id="log_date" name="log_date" type="date" class="block mt-1 w-full" value="{{ old('log_date', date('Y-m-d')) }}" required />
                                <x-input-error :messages="$errors->get('log_date')" class="mt-2" />
                            </div>

                            <div class="flex items-end">
                                <div class="w-full flex items-center">
                                    <input id="completed" name="completed" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ old('completed') ? 'checked' : '' }}>
                                    <label for="completed" class="ml-2 text-sm text-gray-700">Hábito completado</label>
                                </div>
                            </div>

                            <div class="flex items-end">
                                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Guardar log</button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Historial de registros</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-left border-b bg-gray-50">
                                        <th class="py-3 px-4">#</th>
                                        <th class="py-3 px-4">Fecha</th>
                                        <th class="py-3 px-4">Día</th>
                                        <th class="py-3 px-4">Estado</th>
                                        <th class="py-3 px-4">Completado en</th>
                                        <th class="py-3 px-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($logs as $log)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4">{{ $log->id }}</td>
                                            <td class="py-3 px-4 font-medium">{{ $log->log_date->format('Y-m-d') }}</td>
                                            <td class="py-3 px-4 text-gray-600">
                                                @php
                                                    $dayNames = [0 => 'Domingo', 1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado'];
                                                    $dayName = $dayNames[$log->log_date->dayOfWeek];
                                                @endphp
                                                {{ $dayName }}
                                            </td>
                                            <td class="py-3 px-4">
                                                @if($log->completed_at)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">✓ Completado</span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">⏳ Pendiente</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-gray-600">
                                                {{ $log->completed_at ? $log->completed_at->format('H:i') : '—' }}
                                            </td>
                                            <td class="py-3 px-4">
                                                @if(auth()->user()->role === 'admin' || $log->user_id === auth()->id())
                                                    <form method="POST" action="{{ route('habits.logs.destroy', [$habit, $log]) }}" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-700 underline hover:text-red-900" onclick="return confirm('¿Eliminar este registro?')">Eliminar</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="py-4 px-4 text-gray-500 text-center">No hay registros de logs para este hábito.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($logs->hasPages())
                            <div class="mt-4">{{ $logs->links() }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('habits.index') }}" class="px-4 py-2 border rounded hover:bg-gray-50">← Volver a hábitos</a>
            </div>
        </div>
    </div>
</x-app-layout>

