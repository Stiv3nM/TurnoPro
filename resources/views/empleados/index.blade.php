<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Empleados</h1>
    </x-slot>

    @php $nombresDias = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom']; @endphp

    <section class="row justify-content-center">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Lista de empleados (semana del {{ date('d/m', strtotime($dias[0])) }} al {{ date('d/m', strtotime($dias[6])) }})</span>
                    @if (Auth::user()->esAdmin())
                        <a href="{{ route('empleados.create') }}" class="btn btn-primary btn-sm">Nuevo empleado</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-center mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Puesto</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Horario de la semana</th>
                                @if (Auth::user()->esAdmin())
                                    <th scope="col">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($empleados as $e)
                                <tr>
                                    <td>{{ $e->nombre }} {{ $e->apellido }}</td>
                                    <td>{{ $e->correo }}</td>
                                    <td>{{ $e->puesto->nombre }}</td>
                                    <td>{{ $e->puesto->departamento->nombre }}</td>
                                    <td>
                                        @foreach ($dias as $i => $dia)
                                            @php $h = $horarios[$e->id . '-' . $dia] ?? null; @endphp
                                            @if ($h && $h->turno)
                                                <span class="badge text-bg-primary" title="{{ substr($h->turno->hora_inicio, 0, 5) }} a {{ substr($h->turno->hora_fin, 0, 5) }}">{{ $nombresDias[$i] }} {{ $h->turno->tipo }}</span>
                                            @elseif ($h)
                                                <span class="badge text-bg-secondary">{{ $nombresDias[$i] }} Desc.</span>
                                            @else
                                                <span class="badge text-bg-light">{{ $nombresDias[$i] }} -</span>
                                            @endif
                                        @endforeach
                                    </td>
                                    @if (Auth::user()->esAdmin())
                                        <td>
                                            <a href="{{ route('empleados.edit', $e) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('empleados.destroy', $e) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Eliminar este empleado? Se eliminarán también sus horarios.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-secondary py-4">No hay empleados registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
