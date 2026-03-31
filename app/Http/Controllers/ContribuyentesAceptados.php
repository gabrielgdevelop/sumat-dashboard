<?php

namespace App\Http\Controllers;

use App\Models\Contribuyente;
use Illuminate\Http\Request;

class ContribuyentesAceptados extends Controller
{
    
    function index() {

        $contribuyentes = Contribuyente::where('aceptado', 'LIKE', 'aceptado')->paginate(10);
    }
}
