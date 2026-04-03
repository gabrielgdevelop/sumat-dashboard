<?php

namespace App\Http\Controllers;

use App\Models\Contribuyente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContribuyentesAceptados extends Controller
{
    

    public function index()
    {
        $hoy = Carbon::now()->format('Y-m-d');

        // Eventos actuales y futuros
        $contribuyentes = Contribuyente::where('aceptado', 'Aceptado')
            ->where('fecha_evento', '>=', $hoy)
            ->orderBy('fecha_evento', 'desc')
            ->paginate(7);

        // Histórico (Eventos pasados)
        $historico = Contribuyente::where('aceptado', 'Aceptado')
            ->where('fecha_evento', '<', $hoy)
            ->orderBy('fecha_evento', 'desc')
            ->paginate(10); 

        return view('contribuyentes-aceptados.index', compact('contribuyentes', 'historico'));
    }
}
