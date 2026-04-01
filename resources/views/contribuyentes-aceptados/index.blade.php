<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Contribuyentes Aceptados') }}
        </h2>
    </x-slot>  

    <section class="py-7 h-fit">
        @if (count($contribuyentes) > 0)
        <article class="flex gap-2 flex-col items-center h-150">
        @foreach($contribuyentes as $contribuyente)
            <div class="flex gap-2 w-4/5 p-2 h-50 border-b border-blue-500">

                <header class="h-50 border-r border-gray-800 p-2">
                    <h3 class="text-3xl md:text-4xl text-white/90 w-21 font-extrabold">{{ $contribuyente->fecha_evento }}</h3>
                </header>
                <section class="flex flex-col gap-5">
                    <div class="flex flex-col">
                        <div class="text-xl md:text-2xl text-blue-500/70 font-bold">

                            <span class="">{{$contribuyente->nombre}}</span>
                            <span class="">{{$contribuyente->apellido}}</span>
                        </div>
                        <div class="flex gap-1 font-bold md:text-lg text-sm text-blue-400/40">

                            <span>{{ $contribuyente->rif }}</span>
                            <span>{{ $contribuyente->telefono }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h2 class="text-lg font-bold md:text-xl text-white/70">Datos del Evento</h2>
                        <ul class="flex flex-col gap-1 text-white/50 list-disc list-inside">
                            <li class="text-sm md:text-lg">{{ $contribuyente->ubicacion_evento }}</li>
                            <span class="text-md">{{ $contribuyente->tipo_evento }}</span>
                        </ul>
                    </div>
                </section>
            </div>
        @endforeach
        </article>
        @else
        <h2 class="text-red-500 text-xl text-center mt-25 p-2 rounded bg-red-500/30 w-fit m-auto">No se han aceptado contribuyentes</h2>
        @endif

    </section>

</x-app-layout>