<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\Horario;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lunes = date('Y-m-d', strtotime('monday this week'));
        $dias = [];
        for ($i = 0; $i < 7; $i++) {
            $dias[] = date('Y-m-d', strtotime($lunes . ' +' . $i . ' days'));
        }

        $empleados = Empleado::with('puesto.departamento')->orderBy('apellido')->get();

        $horarios = Horario::with('turno')->whereBetween('fecha', [$dias[0], $dias[6]])->get()
            ->keyBy(fn ($h) => $h->empleado_id . '-' . $h->fecha);

        return view('empleados.index', compact('empleados', 'dias', 'horarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $departamentos = Departamento::with('puestos')->orderBy('nombre')->get();
        return view('empleados.create', compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:empleados,correo',
            'puesto_id' => 'required|exists:puestos,id',
        ]);

        Empleado::create($datos);
        return redirect()->route('empleados.index')->with('success', 'Empleado creado.');
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
    public function edit(Empleado $empleado)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $departamentos = Departamento::with('puestos')->orderBy('nombre')->get();
        return view('empleados.edit', compact('empleado', 'departamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $datos = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:empleados,correo,' . $empleado->id,
            'puesto_id' => 'required|exists:puestos,id',
        ]);

        $empleado->update($datos);
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $empleado->delete();
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado.');
    }
}
