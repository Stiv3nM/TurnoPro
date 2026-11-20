<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Horarios</h1>
    </x-slot>

    @php $nombresDias = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom']; @endphp

    <section>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (!$departamento)
            <div class="alert alert-info">Primero crea un departamento.</div>
        @else
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('horarios.index') }}" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label for="departamento_id" class="form-label">Departamento</label>
                            <select class="form-select" id="departamento_id" name="departamento_id">
                                @foreach ($departamentos as $d)
                                    <option value="{{ $d->id }}" @selected($d->id == $departamento->id)>{{ $d->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="semana" class="form-label">Semana (cualquier día de ella)</label>
                            <input type="date" class="form-control" id="semana" name="semana" value="{{ $dias[0] }}">
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Ver</button>
                            <a class="btn btn-outline-secondary" href="{{ route('horarios.index', ['departamento_id' => $departamento->id, 'semana' => date('Y-m-d', strtotime($dias[0] . ' -7 days'))]) }}">Anterior</a>
                            <a class="btn btn-outline-secondary" href="{{ route('horarios.index', ['departamento_id' => $departamento->id, 'semana' => date('Y-m-d', strtotime($dias[0] . ' +7 days'))]) }}">Siguiente</a>
                        </div>
                    </form>
                </div>
            </div>

            <form method="POST" action="{{ route('horarios.guardar') }}">
                @csrf

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">{{ $departamento->nombre }}: {{ date('d/m/Y', strtotime($dias[0])) }} al {{ date('d/m/Y', strtotime($dias[6])) }}</span>
                        @if (Auth::user()->esAdmin())
                            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        @endif
                    </div>

                    <div class="card-body py-2 small text-secondary">Los cuadros con borde amarillo vienen de la semana anterior. Cámbialos si hace falta y pulsa Guardar.</div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="text-start">Empleado</th>
                                    @foreach ($dias as $i => $dia)
                                        <th scope="col">{{ $nombresDias[$i] }}<br><small>{{ date('d/m', strtotime($dia)) }}</small></th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($puestos as $puesto)
                                    <tr class="table-secondary">
                                        <th colspan="8" class="text-start">{{ $puesto->nombre }}</th>
                                    </tr>

                                    @foreach ($puesto->empleados as $e)
                                        <tr>
                                            <td class="text-start">{{ $e->nombre }} {{ $e->apellido }}</td>
                                            @foreach ($dias as $dia)
                                                @php $actual = $valores[$e->id . '-' . $dia] ?? ''; @endphp
                                                <td>
                                                    <select name="h[{{ $e->id }}][{{ $dia }}]" class="form-select form-select-sm {{ isset($sugeridos[$e->id . '-' . $dia]) ? 'border-warning' : '' }}" @disabled(!Auth::user()->esAdmin())>
                                                        <option value="">-</option>
                                                        <option value="D" @selected($actual == 'D')>Desc.</option>
                                                        @foreach ($turnos as $t)
                                                            <option value="{{ $t->id }}" @selected($actual == $t->id)>{{ $t->tipo }} - {{ $t->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td class="text-start text-secondary small">Cobertura</td>
                                        @foreach ($dias as $i => $dia)
                                            <td class="small">
                                                @foreach (['AM', 'MID', 'PM'] as $tipo)
                                                    @if (isset($cobertura[$puesto->id][$i + 1][$tipo]))
                                                        @php $c = $cobertura[$puesto->id][$i + 1][$tipo]; @endphp
                                                        <div class="{{ $c[0] >= $c[1] ? 'text-success' : 'text-danger' }}">{{ $tipo }} {{ $c[0] }}/{{ $c[1] }}</div>
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-secondary py-4">Este departamento no tiene puestos.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        @endif
    </section>
</x-app-layout>
