<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Turnos</h1>
    </x-slot>

    <section class="row justify-content-center">
        <div class="col-lg-10">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Lista de turnos</span>
                    @if (Auth::user()->esAdmin())
                        <a href="{{ route('turnos.create') }}" class="btn btn-primary btn-sm">Nuevo turno</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-center mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Hora de inicio</th>
                                <th scope="col">Hora de fin</th>
                                @if (Auth::user()->esAdmin())
                                    <th scope="col">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($turnos as $t)
                                <tr>
                                    <td>{{ $t->nombre }}</td>
                                    <td>{{ $t->tipo }}</td>
                                    <td>{{ substr($t->hora_inicio, 0, 5) }}</td>
                                    <td>{{ substr($t->hora_fin, 0, 5) }}</td>
                                    @if (Auth::user()->esAdmin())
                                        <td>
                                            <a href="{{ route('turnos.edit', $t) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('turnos.destroy', $t) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Eliminar este turno?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-secondary py-4">No hay turnos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
