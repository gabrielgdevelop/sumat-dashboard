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
    public function show(Contribuyente $contribuyente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idContribuyente)
    {
        $contribuyente = Contribuyente::find($idContribuyente);
        $msg;

        if ($request->aceptado) {

            $contribuyente['aceptado'] = true;
            $msg = 'Contribuyente aceptado';
        } else {

            $contribuyente['aceptado'] = false;
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
