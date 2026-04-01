<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Contribuyentes Aceptados') }}
        </h2>
    </x-slot>   

    <section class="py-12">
        @foreach($contribuyentes as $contribuyente)
        <article class="flex gap-2 flex-col ">
            <div>

                <div class="border-r border-gray-300">
                    <h3>{{ $contribuyente->fecha_evento }}</h3>
                </div>
                <div>
    
                </div>
            </div>
        </article>
        @endforeach
    </section>

</x-app-layout>