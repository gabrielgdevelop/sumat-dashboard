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
                            @foreach($contribuyentes as $contribuyente)
                            <tr>
                                <td>{{ $contribuyente->nombre }} {{ $contribuyente->apellido }} </td>
                                <td>{{ $contribuyente->dni }}</td>
                                <td>{{ $contribuyente->telefono }}</td>
                                <td>{{ $contribuyente->correo }}</td>
                                <td>{{ $contribuyente->fecha_evento }}</td>
                                <td>{{ $contribuyente->ubicacion_evento }}</td>
                                <td>
                                    {{ $contribuyente->aceptado ? 'Aceptado' : 'Rechazado' }}
                                    <form action="{{ route('contribuyente.update', $contribuyente->id) }}">
                                        @csrf 
                                        @method('PUT')
                                        <input type="text" value="true" name="aceptado" hidden>
                                        <input type="submit" value="si">
                                    </form>
                                    <form action="{{ route('contribuyente.update', $contribuyente->id) }}">
                                        @csrf 
                                        @method('PUT')
                                        <input type="text" value="" name="aceptado" hidden>
                                        <input type="submit" value="no">
                                    </form>
                                </td>
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
