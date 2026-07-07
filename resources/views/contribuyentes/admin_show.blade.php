<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-cobalto leading-tight">Contribuyente: {{ $contribuyente->nombre }} {{ $contribuyente->apellido }}</h2>
            <div>
                <a href="{{ route('contribuyentes.admin.edit', $contribuyente->id) }}" class="px-3 py-1 bg-cobalto text-blanco rounded">Editar</a>
                <a href="{{ route('contribuyentes.admin.index') }}" class="ml-2 text-sm text-gray-600">Volver</a>
            </div>
        </div>
    </x-slot>

    <section class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold mb-2">Datos personales</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <div>DNI: {{ $contribuyente->dni }}</div>
                    <div>Teléfono: {{ $contribuyente->telefono }}</div>
                    <div>Correo: {{ $contribuyente->correo }}</div>
                    <div>RIF: {{ $contribuyente->rif }}</div>
                </div>

                <h3 class="font-semibold mb-2">Historial de eventos</h3>
                @if($eventos->isEmpty())
                    <p class="text-gray-500">No hay eventos.</p>
                @else
                    <ul class="space-y-2">
                        @foreach($eventos as $e)
                            <li class="p-2 border rounded flex justify-between items-center">
                                <div>
                                    <div class="font-medium">{{ $e->ubicacion_evento }}</div>
                                    <div class="text-sm text-gray-600">{{ $e->fecha_evento ? \Carbon\Carbon::parse($e->fecha_evento)->format('d/m/Y') : '' }} {{ $e->hora_inicio_evento ?? '' }} {{ $e->hora_fin_evento ? '- '.$e->hora_fin_evento : '' }}</div>
                                </div>
                                <a href="{{ route('contribuyentes.show', $e->id) }}" class="text-cian">Ver detalle</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>
</x-app-layout>
