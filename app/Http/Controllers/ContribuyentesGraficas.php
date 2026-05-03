<?php

namespace App\Http\Controllers;

use App\Models\Contribuyente;
use Illuminate\Http\Request;

class ContribuyentesGraficas extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $year = $request->year;

        $data = DB::table('contribuyentes')
            ->selectRaw('EXTRACT(MONTH FROM fecha_evento) as mes, COUNT(*) as total')
            ->where('aceptado', true)
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
     * Show the form for creating a new resource.
     */
    public function create()
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
    public function show(Contribuyente $contribuyente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contribuyente $contribuyente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contribuyente $contribuyente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribuyente $contribuyente)
    {
        //
    }
}
