<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Datos del contribuyente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6">
            <div>

                <h3>Contribuyente: {{ $contribuyente->nombre }} {{ $contribuyente->apellido }}</h3>
            </div>
            <div>
                <span>DNI: {{ $contribuyente->dni }}</span>
                <span>Teléfono: {{ $contribuyente->telefono }}</span>
            </div>
            <div>
                <span>Correo: {{ $contribuyente->correo }}</span>
            </div>
            <div>
                <span>RIF: {{ $contribuyente->rif }}</span>
            </div>
            <div>
                <span>Ubicación del evento: {{ $contribuyente->ubicacion_evento }}</span>
            </div>
            <div>
                <span>Fecha del evento: {{ $contribuyente->fecha_evento }}</span>
            </div>
            <h3>Tipo de evento</h3>
            <p>{{ $contribuyente->tipo_evento }}</p>
        </div>
    </div>
</x-app-layout>
