<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Estado;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // buscar el id del estado 'pendiente'
        $pendiente = Estado::where('nombre', 'pendiente')->first();
        $pendienteId = $pendiente ? $pendiente->id : null;

        if ($pendienteId) {
            $eventos = Evento::with(['contribuyente', 'parroquia', 'estado'])
                ->where('id_estado', $pendienteId)
                ->orderByDesc('id')
                ->paginate(10);
        } else {
            $eventos = Evento::with(['contribuyente', 'parroquia', 'estado'])
                ->whereRaw('1 = 0')
                ->paginate(10);
        }

        return view('dashboard', compact('eventos'));
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
    public function show(Dasboard $dasboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dasboard $dasboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dasboard $dasboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dasboard $dasboard)
    {
        //
    }
}
