<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $turnos = Turno::orderBy('hora_inicio')->get();
        return view('turnos.index', compact('turnos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        return view('turnos.create');
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
            'nombre' => 'required|string|max:100|unique:turnos,nombre',
            'tipo' => 'required|in:AM,MID,PM',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|different:hora_inicio',
        ]);

        if ($this->pasaDeOchoHoras($datos['hora_inicio'], $datos['hora_fin'])) {
            return back()->withInput()->withErrors(['hora_fin' => 'El turno no puede durar más de 8 horas.']);
        }

        Turno::create($datos);
        return redirect()->route('turnos.index')->with('success', 'Turno creado.');
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
    public function edit(Turno $turno)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        return view('turnos.edit', compact('turno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Turno $turno)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $datos = $request->validate([
            'nombre' => 'required|string|max:100|unique:turnos,nombre,' . $turno->id,
            'tipo' => 'required|in:AM,MID,PM',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|different:hora_inicio',
        ]);

        if ($this->pasaDeOchoHoras($datos['hora_inicio'], $datos['hora_fin'])) {
            return back()->withInput()->withErrors(['hora_fin' => 'El turno no puede durar más de 8 horas.']);
        }

        $turno->update($datos);
        return redirect()->route('turnos.index')->with('success', 'Turno actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Turno $turno)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        if ($turno->horarios()->exists()) {
            return back()->with('error', 'Ese turno está en uso en los horarios.');
        }

        $turno->delete();
        return redirect()->route('turnos.index')->with('success', 'Turno eliminado.');
    }

    private function pasaDeOchoHoras($inicio, $fin)
    {
        $inicio = strtotime($inicio);
        $fin = strtotime($fin);

        if ($fin <= $inicio) {
            $fin = $fin + 86400;
        }

        return ($fin - $inicio) > 8 * 3600;
    }
}
