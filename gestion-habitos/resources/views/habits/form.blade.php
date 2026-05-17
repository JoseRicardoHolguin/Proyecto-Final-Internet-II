<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($habit) && $habit->exists ? 'Editar hábito' : 'Nuevo hábito' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-green-800">
                    <div class="flex">
                        <span class="text-green-600 mr-3">✓</span>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                    <div class="flex">
                        <span class="text-red-600 mr-3 font-bold">!</span>
                        <div>
                            <p class="text-red-800 font-semibold">Errores de validación:</p>
                            <ul class="list-disc pl-5 mt-2">
                                @foreach($errors->all() as $error)
                                    <li class="text-red-700">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg">
                <form method="POST" action="{{ isset($habit) && $habit->exists ? route('habits.update', $habit) : route('habits.store') }}" class="p-6 space-y-6">
                    @csrf
                    @if(isset($habit) && $habit->exists)
                        @method('PUT')
                    @endif

                    <div>
                        <x-input-label for="title" :value="__('Título del hábito')" />
                        <x-text-input 
                            id="title" 
                            name="title" 
                            class="block mt-2 w-full" 
                            type="text" 
                            value="{{ old('title', $habit->title ?? '') }}" 
                            placeholder="Ej: Hacer ejercicio, Leer, Meditar..."
                            required 
                            autofocus 
                        />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Descripción (opcional)')" />
                        <textarea 
                            id="description" 
                            name="description" 
                            class="block mt-2 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" 
                            rows="4"
                            placeholder="Describe tu hábito en detalle..."
                        >{{ old('description', $habit->description ?? '') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="border-t pt-6">
                        <div class="flex items-center">
                            <input 
                                id="is_active" 
                                name="is_active" 
                                type="checkbox" 
                                value="1" 
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" 
                                {{ old('is_active', $habit->is_active ?? true) ? 'checked' : '' }}
                            >
                            <label for="is_active" class="ml-3 text-sm font-medium text-gray-700">
                                Este hábito está activo
                            </label>
                            <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Los hábitos inactivos no aparecerán en tu dashboard.</p>
                    </div>

                    <div class="border-t pt-6 flex gap-4">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium">
                            {{ isset($habit) && $habit->exists ? 'Actualizar hábito' : 'Crear hábito' }}
                        </button>
                        <a href="{{ route('habits.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium text-gray-700">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

