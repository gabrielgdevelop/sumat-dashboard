<x-app-layout>
    @vite(['resources/js/contribuyentes-aceptados/index.js'])

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-cobalto leading-tight">{{ __('Contribuyentes Aceptados') }}</h2>
            <button id="btnAbrirHistorial" class="bg-cobalto text-blanco font-bold py-2 px-4 rounded transition">Eventos pasados</button>
        </div>
    </x-slot>

    <section class="py-7 h-fit">
        @if ($contribuyentes->count() > 0)
            <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-11/12 m-auto">
                @foreach($contribuyentes as $evento)
                    <div class="bg-gray-300/40 hover:bg-gray-400/40 border border-cobalto rounded-lg p-4 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start justify-between mb-2 gap-3">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-cobalto">{{ optional($evento->contribuyente)->nombre }} {{ optional($evento->contribuyente)->apellido }}</div>
                                <div class="text-sm text-cobalto">{{ optional($evento->contribuyente)->correo }}</div>
                            </div>
                            <div class="text-right flex flex-col items-end gap-1">
                                <div class="text-xs text-black">{{ $evento->fecha_evento ? \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y') : '' }}</div>
                                <span class="inline-block mt-1 bg-verde-lima text-xs px-2 py-0.5 rounded-full text-verde-lima font-bold">ACEPTADO</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('contribuyentes.show', $evento->id) }}" class="px-3 py-1 bg-cobalto hover:bg-cobalto-dark text-blanco rounded">Ver detalle</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-11/12 m-auto mt-4">{{ $contribuyentes->links() }}</div>
        @else
            <h2 class="text-red-500 text-xl text-center mt-25 p-2 rounded bg-red-500/30 w-fit m-auto">No se han aceptado contribuyentes próximos</h2>
        @endif
    </section>

    <div id="modalHistorial" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="modalOverlay" class="fixed inset-0 bg-white/30 backdrop-blur-sm"></div>

        <div class="relative bg-white w-full max-w-5xl max-h-[90vh] overflow-y-auto rounded-xl shadow-2xl p-6">
            <div class="flex justify-between items-center mb-6 border-b border-cobalto pb-4">
                <h2 class="text-2xl font-bold text-cobalto">Historial de Eventos Pasados</h2>
                <button id="btnCerrarHistorial" class="text-cian hover:text-red-500 text-3xl font-bold">&times;</button>
            </div>

            <article class="flex gap-4 flex-col items-center">
                @forelse($historico as $pasado)
                <div class="w-11/12 m-auto">
                    <div class="bg-gray-300/40 hover:bg-gray-400/40 border border-cobalto rounded-lg p-4 shadow-sm hover:shadow-md transition">
                        <div class="flex items-start justify-between mb-2 gap-3">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-cobalto">{{ optional($pasado->contribuyente)->nombre }} {{ optional($pasado->contribuyente)->apellido }}</div>
                                <div class="text-sm text-cobalto">{{ optional($pasado->contribuyente)->correo }}</div>
                            </div>
                            <div class="text-right flex flex-col items-end gap-1">
                                <div class="text-xs text-black">{{ $pasado->fecha_evento ? \Carbon\Carbon::parse($pasado->fecha_evento)->format('d/m/Y') : '' }}</div>
                                <span class="inline-block mt-1 bg-verde-lima text-xs px-2 py-0.5 rounded-full text-verde-lima font-bold">ACEPTADO</span>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('contribuyentes.show', $pasado->id) }}" class="px-3 py-1 bg-cobalto hover:bg-cobalto-dark text-blanco rounded">Ver detalle</a>
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-gray-500 text-center py-10">No hay registros en el historial.</p>
                @endforelse
            </article>
        </div>
    </div>
</x-app-layout>