<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $fillable = [
        'ubicacion_evento',
        'fecha_evento',
        'hora_inicio',
        'hora_fin',
        'tipo_evento',
        'id_estado',
        'parroquia_id',
    ];

    public function parroquia()
    {
        return $this->belongsTo(Parroquia::class);
    }

    public function contribuyente()
    {
        return $this->belongsTo(\App\Models\Contribuyente::class);
    }

    public function estado()
    {
        return $this->belongsTo(\App\Models\Estado::class, 'id_estado');
    }
}
