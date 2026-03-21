<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribuyente extends Model
{

    protected $fillable = [

        'nombre',
        'apellido',
        'dni',
        'telefono',
        'correo',
        'ubicacion_evento',
        'rif',
        'fecha_evento',
        'tipo_evento',
    ];
}
