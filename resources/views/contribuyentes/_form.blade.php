<div>
    @if($errors->any())
        <div class="mb-4 text-red-600">{{ $errors->first() }}</div>
    @endif

    <form action="{{ $action }}" method="POST">
        @csrf
        @if(!empty($method) && strtoupper($method) !== 'POST')
            @method($method)
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1">Nombre</label>
                <input name="nombre" value="{{ old('nombre', $contribuyente->nombre ?? '') }}" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1">Apellido</label>
                <input name="apellido" value="{{ old('apellido', $contribuyente->apellido ?? '') }}" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1">Cédula</label>
                <input name="dni" value="{{ old('dni', $contribuyente->dni ?? '') }}" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1">Teléfono</label>
                <input name="telefono" value="{{ old('telefono', $contribuyente->telefono ?? '') }}" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1">Correo</label>
                <input name="correo" type="email" value="{{ old('correo', $contribuyente->correo ?? '') }}" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1">RIF</label>
                <input name="rif" value="{{ old('rif', $contribuyente->rif ?? '') }}" required class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1">Contraseña</label>
                <input name="password" type="password" {{ (isset($contribuyente) ? '' : 'required') }} class="w-full border px-3 py-2 rounded">
            </div>
            <div>
                <label class="block mb-1">Confirmar Contraseña</label>
                <input name="password_confirmation" type="password" {{ (isset($contribuyente) ? '' : 'required') }} class="w-full border px-3 py-2 rounded">
            </div>
        </div>

        <div class="mt-4">
            <button class="px-4 py-2 bg-cobalto text-white rounded">{{ $submitText ?? 'Guardar' }}</button>
            <a href="{{ $cancelUrl ?? route('contribuyentes.admin.index') }}" class="ml-2 text-sm text-gray-600">Cancelar</a>
        </div>
    </form>
</div>
