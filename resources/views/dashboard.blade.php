<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Solicitudes de los contribuyentes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 ">
            <div class="overflow-hidden shadow-sm">
                <div class="text-gray-100 ">
                    <table class="bg-gray-800 rounded-lg w-full">
                        <thead>
                            <tr class="border-b border-">
                                <th class="p-2">Contribuyente</th>
                                <th class="p-2">DNI</th>
                                <th class="p-2">Teléfono</th>
                                <th class="p-2">Correo</th>
                                <th class="p-2">Fecha del evento</th>
                                <th class="p-2">Dirección</th>
                                <th class="p-2">Detalles</th>
                                <th class="p-2">Aceptar / Rechazar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contribuyentes as $contribuyente)
                            <tr>
                                <td class="p-3 text-center text-sm">{{ $contribuyente->nombre }} {{ $contribuyente->apellido }} </td>
                                <td class="p-3 text-center text-sm">{{ $contribuyente->dni }}</td>
                                <td class="p-3 text-center text-sm">{{ $contribuyente->telefono }}</td>
                                <td class="p-3 text-center text-sm">{{ $contribuyente->correo }}</td>
                                <td class="p-3 text-center text-sm">{{ $contribuyente->fecha_evento }}</td>
                                <td class="p-3 text-center text-sm">{{ $contribuyente->ubicacion_evento }}</td>
                                <td class="p-3 text-center text-sm">
                                    <a href="{{ route('contribuyentes.show', $contribuyente->id) }}"
                                        class="text-blue-500">Más detalles</a>
                                </td>
                                <td class="p-3 flex gap-2 flex-col justify-between items-center">
                                    <span class="font-bold border-b">{{ $contribuyente->aceptado ? 'Aceptado' : 'Rechazado' }}</span>
                                    <div class="flex flex-1 gap-2 w-full">

                                        <form action="{{ route('contribuyente.update', $contribuyente->id) }}"
                                            class="w-full">
                                            @csrf 
                                            @method('PUT')
                                            <input type="text" value="true" name="aceptado" hidden>
                                            <input type="submit" value="Si" 
                                            class="bg-green-500 w-full px-2 rounded-lg py-1 cursor-pointer">
                                        </form>
                                        <form action="{{ route('contribuyente.update', $contribuyente->id) }}"
                                            class="w-full">
                                            @csrf 
                                            @method('PUT')
                                            <input type="text" value="" name="aceptado" hidden>
                                            <input type="submit" value="No"
                                            class="bg-red-500 w-full px-2 rounded-lg py-1 cursor-pointer">
                                        </form>
                                    </div>
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
