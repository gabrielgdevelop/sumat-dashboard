<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cobalto leading-tight">Crear contribuyente</h2>
    </x-slot>

    <section class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                @include('contribuyentes._form', [
                    'action' => route('contribuyentes.store'),
                    'method' => 'POST',
                    'submitText' => 'Crear',
                    'cancelUrl' => route('dashboard'),
                ])
            </div>
        </div>
    </section>
</x-app-layout>
