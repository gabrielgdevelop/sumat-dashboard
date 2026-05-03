<?php

namespace App\Http\Controllers;

use App\Models\Contribuyente;
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
        $contribuyente = Contribuyente::findOrFail($id);
        
        return view('contribuyentes.show', compact('contribuyente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idContribuyente)
    {
        $contribuyente = Contribuyente::find($idContribuyente);
        $msg;

        if ($request->aceptado === 'true') {

            $contribuyente['aceptado'] = 'Aceptado';
            $msg = 'Contribuyente aceptado';
        } else {

            $contribuyente['aceptado'] = 'Rechazado';
            $msg = 'Contribuyente rechazado';
        }

        $contribuyente->save();

        return redirect()->route('dashboard')->with('msg_upd', $msg);
    }

    public function graficaPorYear(Request $request) {

        $year = $request->year;

        $data = DB::table('contribuyentes')
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
