<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Días del hábito: {{ $habit->title }}</h2>
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
                    <form method="POST" action="{{ route('habits.days.store', $habit) }}" class="flex items-end gap-4">
                        @csrf
                        <div class="flex-1">
                            <x-input-label for="day_of_week" :value="__('Selecciona un día')" />
                            <select id="day_of_week" name="day_of_week" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">-- Seleccionar --</option>
                                <option value="1" {{ old('day_of_week') == 1 ? 'selected' : '' }}>Lunes</option>
                                <option value="2" {{ old('day_of_week') == 2 ? 'selected' : '' }}>Martes</option>
                                <option value="3" {{ old('day_of_week') == 3 ? 'selected' : '' }}>Miércoles</option>
                                <option value="4" {{ old('day_of_week') == 4 ? 'selected' : '' }}>Jueves</option>
                                <option value="5" {{ old('day_of_week') == 5 ? 'selected' : '' }}>Viernes</option>
                                <option value="6" {{ old('day_of_week') == 6 ? 'selected' : '' }}>Sábado</option>
                                <option value="7" {{ old('day_of_week') == 7 ? 'selected' : '' }}>Domingo</option>
                            </select>
                            <x-input-error :messages="$errors->get('day_of_week')" class="mt-2" />
                        </div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Agregar día</button>
                    </form>

                    <div class="mt-6">
                        <div class="text-gray-700 mb-4 font-semibold">Días configurados</div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-left border-b bg-gray-50">
                                        <th class="py-3 px-4">#</th>
                                        <th class="py-3 px-4">Día de la semana</th>
                                        <th class="py-3 px-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($days as $day)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4">{{ $day->id }}</td>
                                            <td class="py-3 px-4">
                                                @php
                                                    $dayNames = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
                                                @endphp
                                                {{ $dayNames[$day->day_of_week] }}
                                            </td>
                                            <td class="py-3 px-4">
                                                <form method="POST" action="{{ route('habits.days.destroy', [$habit, $day]) }}" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-700 underline hover:text-red-900" onclick="return confirm('¿Eliminar este día?')">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="py-4 px-4 text-gray-500 text-center">No hay días registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('habits.index') }}" class="px-4 py-2 border rounded hover:bg-gray-50">← Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

