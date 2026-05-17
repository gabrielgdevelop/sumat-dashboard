<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContribuyentesAceptados extends Controller
{
    

    public function index()
    {
        $hoy = Carbon::now()->format('Y-m-d');

        // Eventos actuales y futuros (filtrados por estado 'aceptado')
        $contribuyentes = Evento::with(['contribuyente', 'estado'])
            ->whereHas('estado', function($q) {
                $q->where('nombre', 'aceptado');
            })
            ->where('fecha_evento', '>=', $hoy)
            ->orderBy('fecha_evento', 'desc')
            ->paginate(7);

        // Histórico (Eventos pasados aceptados)
        $historico = Evento::with(['contribuyente', 'estado'])
            ->whereHas('estado', function($q) {
                $q->where('nombre', 'aceptado');
            })
            ->where('fecha_evento', '<', $hoy)
            ->orderBy('fecha_evento', 'desc')
            ->paginate(10);

        return view('contribuyentes-aceptados.index', compact('contribuyentes', 'historico'));
    }
}
