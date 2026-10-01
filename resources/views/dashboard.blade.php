<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cobalto leading-tight">
            {{ __('Solicitudes de los contribuyentes') }}
        </h2>
    </x-slot>

    <section class="py-12">
        @if ($eventos->count() > 0)
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="space-y-3">
                @foreach($eventos as $evento)
                    <div class="flex items-center justify-between bg-gray-300/40 hover:bg-gray-300/70 transition border border-cobalto rounded-lg p-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-cobalto text-blanco flex items-center justify-center font-bold text-lg">
                                {{ strtoupper(substr(optional($evento->contribuyente)->nombre ?? 'C', 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-cobalto">
                                    {{ optional($evento->contribuyente)->nombre }} {{ optional($evento->contribuyente)->apellido }}
                                </div>
                                <div class="text-sm text-cobalto flex gap-3 items-center">
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cobalto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $evento->fecha_evento ? \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y') : '' }}
                                    </span>
                                    <span class="text-white/40">•</span>
                                    <span>{{ $evento->ubicacion_evento }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                        <a href="{{ route('contribuyentes.show', $evento->id) }}" class="text-cian hover:underline">Más detalles</a>

                        <form action="{{ route('contribuyente.update', $evento->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <input type="hidden" value="true" name="aceptado">
                            <button type="submit" class="bg-verde-lima bg-cobalto text-white border border-cobalto px-3 py-1 rounded-md font-semibold">Aceptar</button>
                        </form>

                        <!-- Modal de Motivo de Rechazo -->
                        <div x-data="{ openModal: false }" class="inline-block">
                            <button @click="openModal = true" type="button" class="bg-red-500 text-blanco px-3 py-1 rounded-md font-semibold hover:bg-red-600 transition">Rechazar</button>

                            <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak>
                                <div @click.away="openModal = false" class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
                                    <h3 class="text-lg font-bold text-cobalto mb-4">Motivo de Rechazo</h3>
                                    <form action="{{ route('contribuyente.update', $evento->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" value="false" name="aceptado">
                                        <textarea name="motivo_rechazo" rows="3" class="w-full border border-gray-300 rounded p-2 mb-4 focus:ring-cobalto" placeholder="Explique por qué se deniega el permiso..." required></textarea>
                                        <div class="flex justify-end gap-3">
                                            <button @click="openModal = false" type="button" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md">Cancelar</button>
                                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md font-semibold">Confirmar Rechazo</button>
                                        </div>
                                    </form>
            </div>
        </div>
    </div>
</div>
                    </div>
                @endforeach

                <div class="mt-4">
                    {{ $eventos->links() }}
                </div>
            </div>
        </div>
        @else
            <h2 class="text-red-500 text-xl text-center mt-25 p-2 rounded bg-red-500/30 w-fit m-auto">No hay solicitudes de contribuyentes</h2>
        @endif
    </section>
</x-app-layout>
