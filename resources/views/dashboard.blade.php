<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Solicitudes de los contribuyentes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <table>
                        <thead>
                            <tr>
                                <th>Contribuyente</th>
                                <th>DNI</th>
                                <th>Teléfono</th>
                                <th>Correo</th>
                                <th>Fecha del evento</th>
                                <th>Dirección</th>
                                <th>Aceptación / Rechazo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contribuytentes as $contribuyente)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
