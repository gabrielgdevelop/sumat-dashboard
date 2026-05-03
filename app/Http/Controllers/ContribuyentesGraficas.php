<?php

namespace App\Http\Controllers;

use App\Models\Contribuyente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ContribuyentesGraficas extends Controller
{   
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $years = DB::table('contribuyentes')
            ->selectRaw('EXTRACT(YEAR FROM fecha_evento) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();
        return view('contribuyentes-graficas.index', compact('years')); 
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
