<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        {{ __('Top 10 hábitos') }}
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
@forelse($habits as $habit)
                            @php
                                // Usamos la info de las tablas: habit_days y habit_logs
                                $day = $habit->days->first();
                                $log = $habit->logs->sortByDesc('log_date')->first();
                                $daysCount = $habit->days->count();
                                $logsCount = $habit->logs->count();
                            @endphp


                            <div class="border rounded-lg p-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="font-semibold text-lg">Hábito {{ $habit->id }}: {{ $habit->title }}</div>
                                        <div class="text-sm text-blue-600 mt-2 font-medium">
                                            usa habits_days ({{ $daysCount }}) y habits_logs ({{ $logsCount }})
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="text-sm font-medium text-gray-700">{{ __('Detalles de Habit Days') }}</div>
                                    @if($daysCount > 0)
                                        <div class="text-sm text-gray-600 mt-1">
                                            IDs: {{ $habit->days->pluck('id')->join(', ') }}
                                        </div>
                                        @foreach($habit->days as $habitDay)
                                            <div class="text-sm text-gray-600">
                                                • habits_days {{ $habitDay->id }}: {{ $habitDay->day_of_week }}
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-sm text-gray-600 mt-1">{{ __('Sin habit_days') }}</div>
                                    @endif
                                </div>

                                <div class="mt-4">
                                    <div class="text-sm font-medium text-gray-700">{{ __('Detalles de Habit Logs') }}</div>
                                    @if($logsCount > 0)
                                        <div class="text-sm text-gray-600 mt-1">
                                            IDs: {{ $habit->logs->pluck('id')->join(', ') }}
                                        </div>
                                        @foreach($habit->logs->sortByDesc('id')->take(3) as $habitLog)
                                            <div class="text-sm text-gray-600">
                                                • habits_logs {{ $habitLog->id }}: {{ $habitLog->log_date instanceof \DateTimeInterface ? $habitLog->log_date->format('Y-m-d') : $habitLog->log_date }} - {{ $habitLog->completed_at ? __('Completado') : __('Pendiente') }}
                                            </div>
                                        @endforeach
                                        @if($logsCount > 3)
                                            <div class="text-sm text-gray-500 mt-1">
                                                ... y {{ $logsCount - 3 }} más
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-sm text-gray-600 mt-1">{{ __('Sin habit_logs') }}</div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-gray-600">{{ __('No hay hábitos para mostrar.') }}</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

