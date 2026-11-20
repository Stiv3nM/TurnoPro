<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\Horario;
use App\Models\Turno;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index(Request $request)
    {
        $departamentos = Departamento::orderBy('nombre')->get();
        $departamento = Departamento::find($request->departamento_id) ?? $departamentos->first();

        $fecha = $request->semana ?? date('Y-m-d');
        $lunes = date('Y-m-d', strtotime('monday this week', strtotime($fecha)));

        $dias = [];
        for ($i = 0; $i < 7; $i++) {
            $dias[] = date('Y-m-d', strtotime($lunes . ' +' . $i . ' days'));
        }

        $turnos = Turno::orderBy('hora_inicio')->get();
        $puestos = [];
        $valores = [];
        $sugeridos = [];
        $cobertura = [];

        if ($departamento) {
            $puestos = $departamento->puestos()->with('empleados', 'requerimientos')->orderBy('nombre')->get();

            $ids = [];
            foreach ($puestos as $puesto) {
                foreach ($puesto->empleados as $empleado) {
                    $ids[] = $empleado->id;
                }
            }

            $desde = date('Y-m-d', strtotime($dias[0] . ' -7 days'));
            $guardados = Horario::whereIn('empleado_id', $ids)->whereBetween('fecha', [$desde, $dias[6]])->get()
                ->keyBy(fn ($h) => $h->empleado_id . '-' . $h->fecha);

            foreach ($ids as $id) {
                foreach ($dias as $dia) {
                    $h = $guardados[$id . '-' . $dia] ?? null;

                    if ($h) {
                        $valores[$id . '-' . $dia] = $h->turno_id ?? 'D';
                        continue;
                    }

                    $antes = $guardados[$id . '-' . date('Y-m-d', strtotime($dia . ' -7 days'))] ?? null;

                    if ($antes) {
                        $valores[$id . '-' . $dia] = $antes->turno_id ?? 'D';
                        $sugeridos[$id . '-' . $dia] = true;
                    }
                }
            }

            foreach ($puestos as $puesto) {
                foreach ($puesto->requerimientos as $r) {
                    $cuantos = 0;

                    foreach ($puesto->empleados as $empleado) {
                        $valor = $valores[$empleado->id . '-' . $dias[$r->dia_semana - 1]] ?? '';
                        $turno = $turnos->where('id', $valor)->first();

                        if ($turno && $turno->tipo == $r->tipo) {
                            $cuantos++;
                        }
                    }

                    $cobertura[$puesto->id][$r->dia_semana][$r->tipo] = [$cuantos, $r->cantidad];
                }
            }
        }

        return view('horarios.index', compact('departamentos', 'departamento', 'dias', 'puestos', 'valores', 'sugeridos', 'cobertura', 'turnos'));
    }

    public function mio(Request $request)
    {
        $empleado = Empleado::with('puesto.departamento')->where('correo', auth()->user()->email)->first();

        $fecha = $request->semana ?? date('Y-m-d');
        $lunes = date('Y-m-d', strtotime('monday this week', strtotime($fecha)));

        $dias = [];
        for ($i = 0; $i < 7; $i++) {
            $dias[] = date('Y-m-d', strtotime($lunes . ' +' . $i . ' days'));
        }

        $horarios = collect();
        if ($empleado) {
            $horarios = Horario::with('turno')->where('empleado_id', $empleado->id)
                ->whereBetween('fecha', [$dias[0], $dias[6]])->get()->keyBy('fecha');
        }

        return view('horarios.mio', compact('empleado', 'dias', 'horarios'));
    }

    public function guardar(Request $request)
    {
        if (!auth()->user()->esAdmin()) {
            abort(403);
        }

        $request->validate(['h' => 'required|array']);

        foreach ($request->h as $empleado_id => $fechas) {
            foreach ($fechas as $fecha => $valor) {
                Horario::where('empleado_id', $empleado_id)->where('fecha', $fecha)->delete();

                if ($valor == '') {
                    continue;
                }

                Horario::create([
                    'empleado_id' => $empleado_id,
                    'turno_id' => $valor == 'D' ? null : $valor,
                    'fecha' => $fecha,
                ]);
            }
        }

        return back()->with('success', 'Horarios guardados.');
    }
}
