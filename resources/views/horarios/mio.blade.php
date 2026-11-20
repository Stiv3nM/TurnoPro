<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Mi horario</h1>
    </x-slot>

    @php $nombresDias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']; @endphp

    <section class="row justify-content-center">
        <div class="col-lg-8">
            @if (!$empleado)
                <div class="alert alert-info">Tu correo ({{ Auth::user()->email }}) no está registrado como empleado. Pide al administrador que use ese mismo correo.</div>
            @else
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">{{ $empleado->nombre }} {{ $empleado->apellido }} - {{ $empleado->puesto->nombre }} ({{ $empleado->puesto->departamento->nombre }})</span>
                        <div class="d-flex gap-2">
                            <a class="btn btn-gris btn-sm" href="{{ route('mi.horario', ['semana' => date('Y-m-d', strtotime($dias[0] . ' -7 days'))]) }}">Anterior</a>
                            <a class="btn btn-gris btn-sm" href="{{ route('mi.horario', ['semana' => date('Y-m-d', strtotime($dias[0] . ' +7 days'))]) }}">Siguiente</a>
                        </div>
                    </div>
                    <div class="card-body py-2 small text-secondary">Semana del {{ date('d/m/Y', strtotime($dias[0])) }} al {{ date('d/m/Y', strtotime($dias[6])) }}</div>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle text-center mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Día</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Turno</th>
                                    <th scope="col">Horario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dias as $i => $dia)
                                    @php $h = $horarios[$dia] ?? null; @endphp
                                    <tr>
                                        <td>{{ $nombresDias[$i] }}</td>
                                        <td>{{ date('d/m', strtotime($dia)) }}</td>
                                        @if ($h && $h->turno)
                                            <td>{{ $h->turno->nombre }}</td>
                                            <td>{{ substr($h->turno->hora_inicio, 0, 5) }} a {{ substr($h->turno->hora_fin, 0, 5) }}</td>
                                        @elseif ($h)
                                            <td>Descanso</td>
                                            <td>-</td>
                                        @else
                                            <td class="text-secondary">Sin asignar</td>
                                            <td>-</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
