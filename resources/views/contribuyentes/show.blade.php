<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Datos del contribuyente') }}
        </h2>
    </x-slot>

    <div class="py-12 px-1">
        <div class="max-w-3xl mx-auto sm:px-6 bg-gray-800 rounded-lg p-4 py-5 flex flex-col gap-[15px] min-h-50">
            <div class="flex flex-col gap-1">

                <h3 class="font-bold text-white/90">{{ $contribuyente->nombre }} {{ $contribuyente->apellido }}</h3>
                <h4 class="text-white/70 text-sm">{{ $contribuyente->correo }}</h4>
            </div>
            <div class="flex flex-col gap-1">

                <div>
                    <h3 class="text-white/70">Datos Personales</h3>
                </div>
                <div class="bg-gray-700 flex flex-wrap rounded-lg gap-2 p-2  ">
                    <span class="text-white/70 text-xs bg-gray-800 w-fit p-1 rounded-full px-3">DNI: {{ $contribuyente->dni }}</span>
                    <span class="text-white/70 text-xs bg-gray-800 w-fit p-1 rounded-full px-3">Teléfono: {{ $contribuyente->telefono }}</span>
                    <span class="text-white/70 text-xs bg-gray-800 w-fit p-1 rounded-full px-3">RIF: {{ $contribuyente->rif }}</span>
                </div>
            </div>
            <div class="flex flex-col gap-1">

                <div>
                    <h3 class="text-white/70">Datos del Evento</h3>
                </div>
                <div class="bg-gray-700 flex flex-wrap rounded-lg gap-2 p-2  ">
                    <span class="text-white/70 text-xs bg-gray-800 w-fit p-1 rounded-full px-3  ">Ubicación: {{ $contribuyente->ubicacion_evento }}</span>
                    <span class="text-white/70 text-xs bg-gray-800 w-fit p-1 rounded-full px-3  ">Fecha: {{ $contribuyente->fecha_evento }}</span>
                </div>
            </div>
            <div class="flex flex-col gap-1">

                <div>
                    <h3 class="text-white/70">Tipo de Evento</h3>
                </div>
                <div class="bg-gray-700 flex flex-wrap rounded-lg gap-2 p-2  ">
                    <p class="text-white/70 text-xs">{{ $contribuyente->tipo_evento }}</p>
                </div>
            </div>
            <a href="{{ route('dashboard') }}"
            class="text-red-500 text-sm w-fit">Volver</a>
        </div>
    </div>
</x-app-layout>
