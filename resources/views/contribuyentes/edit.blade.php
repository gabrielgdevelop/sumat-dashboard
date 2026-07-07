<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-cobalto leading-tight">Editar contribuyente</h2>
    </x-slot>

    <section class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form action="{{ route('contribuyentes.admin.update', $contribuyente->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-1">Nombre</label>
                            <input name="nombre" value="{{ old('nombre', $contribuyente->nombre) }}" required class="w-full border px-3 py-2 rounded">
                        </div>
                        <div>
                            <label class="block mb-1">Apellido</label>
                            <input name="apellido" value="{{ old('apellido', $contribuyente->apellido) }}" required class="w-full border px-3 py-2 rounded">
                        </div>
                        <div>
                            <label class="block mb-1">Cédula</label>
                            <input name="dni" value="{{ old('dni', $contribuyente->dni) }}" required class="w-full border px-3 py-2 rounded">
                        </div>
                        <div>
                            <label class="block mb-1">Teléfono</label>
                            <input name="telefono" value="{{ old('telefono', $contribuyente->telefono) }}" required class="w-full border px-3 py-2 rounded">
                        </div>
                        <div>
                            <label class="block mb-1">Correo</label>
                            <input name="correo" type="email" value="{{ old('correo', $contribuyente->correo) }}" required class="w-full border px-3 py-2 rounded">
                        </div>
                        <div>
                            <label class="block mb-1">RIF</label>
                            <input name="rif" value="{{ old('rif', $contribuyente->rif) }}" required class="w-full border px-3 py-2 rounded">
                        </div>
                        <div>
                            <label class="block mb-1">Contraseña (dejar vacío para mantener)</label>
                            <input name="password" type="password" class="w-full border px-3 py-2 rounded">
                        </div>
                        <div>
                            <label class="block mb-1">Confirmar Contraseña</label>
                            <input name="password_confirmation" type="password" class="w-full border px-3 py-2 rounded">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button class="px-4 py-2 bg-cobalto text-white rounded">Guardar</button>
                        <a href="{{ route('contribuyentes.admin.index') }}" class="ml-2 text-sm text-gray-600">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
