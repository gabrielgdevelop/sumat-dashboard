<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContribuyenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $evento = Evento::findOrFail($id);

        return view('contribuyentes.show', compact('evento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idContribuyente)
    {
        $evento = Evento::findOrFail($idContribuyente);

        $estadoAceptado = Estado::where('nombre', 'aceptado')->first();
        $estadoRechazado = Estado::where('nombre', 'rechazado')->first();

        if ($request->aceptado === 'true') {
            if ($estadoAceptado) {
                $evento->id_estado = $estadoAceptado->id;
            }
            $msg = 'Evento aceptado';
        } else {
            if ($estadoRechazado) {
                $evento->id_estado = $estadoRechazado->id;
            }
            $msg = 'Evento rechazado';
        }

        $evento->save();

        return redirect()->route('dashboard')->with('msg_upd', $msg);
    }

    public function graficaPorYear(Request $request) {

        $year = $request->year;

        $data = DB::table('eventos')
        ->selectRaw('EXTRACT(MONTH FROM fecha_evento) as mes, COUNT(*) as total')
        ->where('aceptado', 'Aceptado')
        ->whereYear('fecha_evento', $year)
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

        $meses = array_fill(1, 12, 0);

        foreach ($data as $item) {
            $meses[(int)$item->mes] = $item->total;
        }

        return response()->json(array_values($meses));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribuyente $contribuyente)
    {
        //
    }
}
