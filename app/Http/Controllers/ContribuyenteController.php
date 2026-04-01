<?php

namespace App\Http\Controllers;

use App\Models\Contribuyente;
use Illuminate\Http\Request;

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contribuyente $contribuyente)
    {
        //
    }
}
