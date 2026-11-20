<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departamentos = Departamento::with('puestos')->withCount('empleados')->orderBy('nombre')->get();
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        return view('departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:100|unique:departamentos,nombre',
            'puestos' => 'required|string',
        ]);

        $nombres = array_unique(array_filter(array_map('trim', explode("\n", $request->puestos))));

        if (count($nombres) == 0) {
            return back()->withInput()->with('error', 'Escribe al menos un puesto.');
        }

        $departamento = Departamento::create(['nombre' => $request->nombre]);

        foreach ($nombres as $nombre) {
            $departamento->puestos()->create(['nombre' => $nombre]);
        }

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departamento $departamento)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        return view('departamentos.edit', compact('departamento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departamento $departamento)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $request->validate([
            'nombre' => 'required|string|max:100|unique:departamentos,nombre,' . $departamento->id,
            'puestos' => 'required|string',
        ]);

        $nombres = array_unique(array_filter(array_map('trim', explode("\n", $request->puestos))));

        if (count($nombres) == 0) {
            return back()->withInput()->with('error', 'Escribe al menos un puesto.');
        }

        $actuales = [];

        foreach ($departamento->puestos as $puesto) {
            $actuales[] = $puesto->nombre;
            if (!in_array($puesto->nombre, $nombres) && $puesto->empleados()->exists()) {
                return back()->withInput()->with('error', 'El puesto ' . $puesto->nombre . ' tiene empleados, no se puede quitar.');
            }
        }

        $departamento->update(['nombre' => $request->nombre]);

        foreach ($departamento->puestos as $puesto) {
            if (!in_array($puesto->nombre, $nombres)) {
                $puesto->delete();
            }
        }

        foreach ($nombres as $nombre) {
            if (!in_array($nombre, $actuales)) {
                $departamento->puestos()->create(['nombre' => $nombre]);
            }
        }

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        if ($departamento->empleados()->exists()) {
            return back()->with('error', 'Reasigna los empleados primero.');
        }

        $departamento->delete();
        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado.');
    }
}
