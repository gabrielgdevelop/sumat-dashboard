<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Estado;
use App\Models\Contribuyente;
use App\Http\Requests\CreateContribuyenteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ContribuyenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    // Admin list view for contribuyentes
    public function adminIndex()
    {
        $contribuyentes = Contribuyente::orderBy('nombre')->paginate(15);
        return view('contribuyentes.index', compact('contribuyentes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create()
    {
        return view('contribuyentes.create');
    }

    public function store(CreateContribuyenteRequest $request)
    {
        $data = $request->validated();

        try {
            $data['password'] = Hash::make($request->password);
            Contribuyente::create($data);
            Log::info('Contribuyente creado', ['correo' => $data['correo'], 'dni' => $data['dni']]);

            return redirect()->route('contribuyentes.admin.index')->with('msg_upd', 'Contribuyente creado.');
        } catch (\Exception $e) {
            Log::error('Error creando contribuyente: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('contribuyentes.admin.index')->with('msg_upd', 'Error al crear contribuyente. Revisa los registros.');
        }
    }

    // Admin edit form
    public function adminEdit(Contribuyente $contribuyente)
    {
        return view('contribuyentes.edit', compact('contribuyente'));
    }

    // Admin update
    public function adminUpdate(Request $request, Contribuyente $contribuyente)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'dni' => 'required|string|max:10|min:7|unique:contribuyentes,dni,' . $contribuyente->id,
            'telefono' => 'required|string|max:15|min:7|unique:contribuyentes,telefono,' . $contribuyente->id,
            'correo' => 'required|email|max:100|unique:contribuyentes,correo,' . $contribuyente->id,
            'rif' => 'required|string|max:11|min:8|unique:contribuyentes,rif,' . $contribuyente->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $contribuyente->update($data);

        return redirect()->route('contribuyentes.admin.index')->with('msg_upd', 'Contribuyente actualizado.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $evento = Evento::findOrFail($id);

        return view('contribuyentes.show', compact('evento'));
    }

    // Admin show contribuyente details and their eventos
    public function adminShow(Contribuyente $contribuyente)
    {
        $eventos = Evento::where('contribuyente_id', $contribuyente->id)->orderByDesc('fecha_evento')->get();
        return view('contribuyentes.admin_show', compact('contribuyente', 'eventos'));
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
        $contribuyente->delete();

        return redirect()->route('dashboard')->with('msg_upd', 'Contribuyente eliminado.');
    }
}
