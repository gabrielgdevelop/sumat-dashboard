<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cobalto leading-tight">
            {{ __('Datos del contribuyente') }}
        </h2>
    </x-slot>

    <div class="py-12 px-1">
        <div class="max-w-3xl mx-auto sm:px-6 bg-gray-300/30 border border-black/30 rounded-lg p-6 py-5 flex flex-col gap-6 min-h-50">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-cobalto text-blanco flex items-center justify-center font-bold text-xl">
                    {{ strtoupper(substr(optional($evento->contribuyente)->nombre ?? 'C', 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-2xl text-cobalto">{{ optional($evento->contribuyente)->nombre }} {{ optional($evento->contribuyente)->apellido }}</h3>
                    <h4 class="text-cian text-sm">{{ optional($evento->contribuyente)->correo }}</h4>
                </div>
                <div class="text-right">
                    <span class="inline-block bg-cian text-black text-xs px-2 py-1 rounded">{{ $evento->fecha_evento ? \Carbon\Carbon::parse($evento->fecha_evento)->format('d/m/Y') : '' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="text-cobalto font-semibold mb-2">Datos personales</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="text-white/90 bg-gray-500 px-3 py-1 rounded-full text-sm">DNI: {{ optional($evento->contribuyente)->dni }}</span>
                        <span class="text-white/90 bg-gray-500   px-3 py-1 rounded-full text-sm">Teléfono: {{ optional($evento->contribuyente)->telefono }}</span>
                        <span class="text-white/90 bg-gray-500   px-3 py-1 rounded-full text-sm">RIF: {{ optional($evento->contribuyente)->rif }}</span>
                    </div>
                    <!-- Visualización del Documento (Cédula o RIF) -->
                    @php
                        $documento = optional($evento->contribuyente)->documentos()->where('tipo', 'identidad')->first();
                    @endphp

                    @if($documento)
                        <div class="mt-4 p-3 bg-white/50 border border-gray-200 rounded-md">
                            <h5 class="text-sm font-semibold text-gray-700 mb-2">Documento Adjunto (Cédula/RIF)</h5>
                            <a href="{{ env('URL_LANDING') }}/storage/{{ $documento->ruta }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-cobalto text-white text-sm font-medium rounded hover:opacity-90 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Ver Documento
                            </a>
                        </div>
                    @else
                        <div class="mt-4 p-3 bg-red-50 border border-red-100 rounded-md">
                            <p class="text-sm text-red-600">El contribuyente no ha adjuntado ningún documento.</p>
                        </div>
                    @endif
                </div>
                

                <div>
                    <h4 class="text-cobalto font-semibold mb-2">Datos del evento</h4>
                    <div class="p-3 rounded-lg bg-gray-500">
                        <p class="text-white/80">Ubicación: {{ $evento->ubicacion_evento }}</p>
                        <p class="text-white/80 mt-2">Hora de inicio: {{ $evento->hora_inicio ? $evento->hora_inicio : '—' }}</p>
                        <p class="text-white/80 mt-2">Hora de finalización: {{ $evento->hora_fin ? $evento->hora_fin : '—' }}</p>
                        <p class="text-white/80 mt-2">Tipo: {{ $evento->tipo_evento ? $evento->tipo_evento : '—' }}</p>
                        <p class="text-white/80 mt-2">Parroquia: {{ $evento->parroquia->nombre ? $evento->parroquia->nombre : '' }}</p>
                        @if(optional($evento->estado)->nombre)
                            <div class="mt-3">
                                <span class="inline-block text-verde-lima text-xs px-2 py-1 rounded">{{ ucfirst(optional($evento->estado)->nombre) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4 flex gap-3 items-center">
                <a href="{{ route('dashboard') }}" class="px-3 py-2 bg-cobalto text-blanco rounded-md font-semibold">Volver</a>
            </div>
        </div>
    </div>
</x-app-layout>
