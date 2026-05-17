<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-cobalto leading-tight">
                {{ __('Eventos Aceptados') }}
            </h2>
        </div>
    </x-slot>

    <section class="py-7 h-fit ">
        @csrf
        <div class="flex flex-col items-center gap-2 p-2 w-full h-100 justify-center">
            <div class="order-1">

                <select id="yearSelect"
                class="rounded-lg border-none outline-none text-cobalto bg-gray-300">
                    <option value="">Selecciona un año</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->year }}">{{ $year->year }}</option>
                        
                    @endforeach
                </select>
            </div>
            <div class="w-[850px]">
                
                <canvas id="chart"
                class="w-full h-full bg-gray-200 text-cobalto"></canvas>
            </div>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/js/contribuyentes-graficas/index.js'])
</x-app-layout>