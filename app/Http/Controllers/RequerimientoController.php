<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Requerimiento;
use Illuminate\Http\Request;

class RequerimientoController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $departamentos = Departamento::orderBy('nombre')->get();
        $departamento = Departamento::find($request->departamento_id) ?? $departamentos->first();

        $puestos = $departamento ? $departamento->puestos : [];

        $cantidades = [];
        foreach (Requerimiento::all() as $r) {
            $cantidades[$r->puesto_id][$r->tipo][$r->dia_semana] = $r->cantidad;
        }

        return view('requerimientos.index', compact('departamentos', 'departamento', 'puestos', 'cantidades'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $request->validate(['r' => 'required|array']);

        foreach ($request->r as $puesto_id => $tipos) {
            Requerimiento::where('puesto_id', $puesto_id)->delete();

            foreach ($tipos as $tipo => $dias) {
                foreach ($dias as $dia => $cantidad) {
                    if ($cantidad > 0) {
                        Requerimiento::create([
                            'puesto_id' => $puesto_id,
                            'dia_semana' => $dia,
                            'tipo' => $tipo,
                            'cantidad' => $cantidad,
                        ]);
                    }
                }
            }
        }

        return back()->with('success', 'Requerimientos guardados.');
    }
}
