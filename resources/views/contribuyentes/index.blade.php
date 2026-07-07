<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-cobalto leading-tight">Contribuyentes</h2>
            <button id="openCreateModal" class="px-3 py-2 bg-cobalto text-blanco rounded">Crear contribuyente</button>
        </div>
    </x-slot>

    <section class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-4">
                @if(session('msg_upd'))
                    <div class="mb-4 p-2 bg-green-100 text-green-800">{{ session('msg_upd') }}</div>
                @endif

                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="py-2">Nombre</th>
                            <th class="py-2">Correo</th>
                            <th class="py-2">Teléfono</th>
                            <th class="py-2">RIF</th>
                            <th class="py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contribuyentes as $c)
                        <tr class="border-b">
                            <td class="py-2">{{ $c->nombre }} {{ $c->apellido }}</td>
                            <td class="py-2">{{ $c->correo }}</td>
                            <td class="py-2">{{ $c->telefono }}</td>
                            <td class="py-2">{{ $c->rif }}</td>
                            <td class="py-2">
                                <a href="{{ route('contribuyentes.admin.show', $c->id) }}" class="text-cian mr-2">Ver</a>
                                <a href="{{ route('contribuyentes.admin.edit', $c->id) }}" class="text-cobalto mr-2">Editar</a>
                                <form action="{{ route('contribuyentes.destroy', $c->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600" onclick="return confirm('Eliminar contribuyente?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $contribuyentes->links() }}
                </div>
            </div>
        </div>
    </section>

    <!-- Create modal -->
    <div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black/50" id="createModalBackdrop"></div>
        <div class="bg-white rounded-lg shadow-lg z-10 w-full max-w-3xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Crear contribuyente</h3>
                <button id="closeCreateModal" class="text-gray-600">Cerrar</button>
            </div>
            @include('contribuyentes._form', [
                'action' => route('contribuyentes.store'),
                'method' => 'POST',
                'submitText' => 'Crear',
                'cancelUrl' => route('contribuyentes.admin.index'),
            ])
        </div>
    </div>

    <script>
        (function(){
            const openBtn = document.getElementById('openCreateModal');
            const modal = document.getElementById('createModal');
            const closeBtn = document.getElementById('closeCreateModal');
            const backdrop = document.getElementById('createModalBackdrop');

            function show(){ modal.classList.remove('hidden'); modal.classList.add('flex'); }
            function hide(){ modal.classList.remove('flex'); modal.classList.add('hidden'); }

            if(openBtn){ openBtn.addEventListener('click', show); }
            if(closeBtn){ closeBtn.addEventListener('click', hide); }
            if(backdrop){ backdrop.addEventListener('click', hide); }

            // Auto-open modal when validation errors exist (so user sees the form and errors)
            @if($errors->any())
                document.addEventListener('DOMContentLoaded', function(){ show(); });
            @endif
        })();
    </script>
</x-app-layout>
