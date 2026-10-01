<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Estado;
use Carbon\Carbon;

class CalendarioAdminController extends Controller
{
    public function index()
    {
        $estadoAceptado = Estado::where('nombre', 'aceptado')->first();
        $eventos = [];
        
        if ($estadoAceptado) {
            $eventos = Evento::with('parroquia')
                ->where('id_estado', $estadoAceptado->id)
                ->get()
                ->map(function ($evento) {
                    $fecha = Carbon::parse($evento->fecha_evento)->format('Y-m-d');
                    $start = $evento->hora_inicio ? $fecha . 'T' . $evento->hora_inicio : $fecha;
                    $end = $evento->hora_fin ? $fecha . 'T' . $evento->hora_fin : $fecha;

                    return [
                        'title' => $evento->tipo_evento ?? 'Evento Confirmado',
                        'start' => $start,
                        'end' => $end,
                        'description' => 'Ubicación: ' . $evento->ubicacion_evento,
                        'color' => '#695CFE', // Color cobalto de tu tema
                    ];
                })
                ->values()
                ->toArray();
        }

        return view('calendario.index', compact('eventos'));
    }
}