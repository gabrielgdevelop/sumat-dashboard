<x-app-layout>
    @vite(['resources/js/contribuyentes-aceptados/index.js'])

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ __('Contribuyentes Aceptados') }}
            </h2>
            <button id="btnAbrirHistorial" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                Eventos pasados 
            </button>
        </div>
    </x-slot>

    <section class="py-7 h-fit">
        @if (count($contribuyentes) > 0)
            <article class="flex gap-2 flex-col items-center">
                @foreach($contribuyentes as $contribuyente)
                    <div class="flex gap-2 w-4/5 p-2 h-50 border-b border-blue-500">
                        <header class="h-50 border-r border-gray-800 p-2">
                            <h3 class="text-3xl md:text-4xl text-white/90 w-21 font-extrabold">{{ $contribuyente->fecha_evento }}</h3>
                        </header>
                        <section class="flex flex-col gap-5">
                            <div class="flex flex-col">
                                <div class="text-xl md:text-2xl text-blue-500/70 font-bold">
                                    <span>{{$contribuyente->nombre}}</span>
                                    <span>{{$contribuyente->apellido}}</span>
                                </div>
                                <div class="flex gap-1 font-bold md:text-lg text-sm text-blue-400/40">
                                    <span>{{ $contribuyente->rif }}</span>
                                    <span>{{ $contribuyente->telefono }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3">
                                <h2 class="text-lg font-bold md:text-xl text-white/70 text-left">Datos del Evento</h2>
                                <ul class="flex flex-col gap-1 text-white/50 list-disc list-inside text-left">
                                    <li class="text-sm md:text-lg">{{ $contribuyente->ubicacion_evento }}</li>
                                    <span class="text-md">{{ $contribuyente->tipo_evento }}</span>
                                </ul>
                            </div>
                        </section>
                    </div>
                @endforeach
            </article>
            <div class="w-4/5 m-auto mt-4">
                {{ $contribuyentes->links() }}
            </div>
        @else
            <h2 class="text-red-500 text-xl text-center mt-25 p-2 rounded bg-red-500/30 w-fit m-auto">No se han aceptado contribuyentes próximos</h2>
        @endif
    </section>

    <div id="modalHistorial" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div id="modalOverlay" class="fixed inset-0 bg-black/30 backdrop-blur-sm"></div>

        <div class="relative bg-gray-900 border border-blue-500 w-full max-w-5xl max-h-[90vh] overflow-y-auto rounded-xl shadow-2xl p-6">
            <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-4">
                <h2 class="text-2xl font-bold text-blue-400">Historial de Eventos Pasados</h2>
                <button id="btnCerrarHistorial" class="text-white hover:text-red-500 text-3xl font-bold">&times;</button>
            </div>

            <article class="flex gap-4 flex-col items-center">
                @forelse($historico as $pasado)
                    <div class="flex gap-2 w-full p-2 h-50 border-b border-gray-800">
                        <header class="h-50 border-r border-gray-800 p-2">
                            <h3 class="text-3xl md:text-4xl text-white/90 w-21 font-extrabold">{{ $pasado->fecha_evento }}</h3>
                        </header>
                        <section class="flex flex-col gap-5">
                            <div class="flex flex-col text-left">
                                <div class="text-xl md:text-2xl text-blue-500/70 font-bold text-left">
                                    <span>{{$pasado->nombre}}</span>
                                    <span>{{$pasado->apellido}}</span>
                                </div>
                                <div class="flex gap-1 font-bold md:text-lg text-sm text-blue-400/40">
                                    <span>{{ $pasado->rif }}</span>
                                    <span>{{ $pasado->telefono }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-3">
                                <h2 class="text-lg font-bold md:text-xl text-white/70 text-left">Datos del Evento</h2>
                                <ul class="flex flex-col gap-1 text-white/50 list-disc list-inside text-left">
                                    <li class="text-sm md:text-lg">{{ $pasado->ubicacion_evento }}</li>
                                    <span class="text-md">{{ $pasado->tipo_evento }}</span>
                                </ul>
                            </div>
                        </section>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-10">No hay registros en el historial.</p>
                @endforelse
            </article>
        </div>
    </div>
</x-app-layout>