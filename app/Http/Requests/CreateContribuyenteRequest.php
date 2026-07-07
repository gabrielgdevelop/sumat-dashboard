<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateContribuyenteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'apellido.required' => 'El apellido es requerido',
            'dni.required' => 'La cédula es requerida',
            'dni.unique' => 'Esta cédula ya se ha registrado',
            'telefono.required' => 'El teléfono es requerido',
            'correo.required' => 'El correo es requerido',
            'correo.email' => 'El correo debe ser válido',
            'rif.required' => 'El RIF es requerido',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ];
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'dni' => 'required|string|max:10|min:7|unique:contribuyentes,dni',
            'telefono' => 'required|string|max:15|min:7|unique:contribuyentes,telefono',
            'correo' => 'required|email|max:100|unique:contribuyentes,correo',
            'rif' => 'required|string|max:11|min:8|unique:contribuyentes,rif',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
