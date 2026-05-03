<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ __('Contribuyentes Métricas') }}
            </h2>
        </div>
    </x-slot>

    <section class="py-7 h-fit ">
        @csrf
        <div class="flex gap-2 p-2 w-full h-100 justify-center ">
            <div class="order-1">

                <select id="yearSelect"
                class="rounded-lg border-none outline-none text-white/80 bg-gray-800">
                    <option value="">Selecciona un año</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->year }}">{{ $year->year }}</option>
                        
                    @endforeach
                </select>
            </div>
            <div class="w-[850px]">
                
                <canvas id="chart"
                class="w-full h-full bg-gray-800 text-white"></canvas>
            </div>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/js/contribuyentes-graficas/index.js'])
</x-app-layout>