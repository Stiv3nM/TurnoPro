<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Departamentos</h1>
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
                    <span class="fw-semibold">Lista de departamentos</span>
                    @if (Auth::user()->esAdmin())
                        <a href="{{ route('departamentos.create') }}" class="btn btn-primary btn-sm">Nuevo departamento</a>
                    @endif
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-center mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Puestos</th>
                                <th scope="col">Empleados</th>
                                @if (Auth::user()->esAdmin())
                                    <th scope="col">Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departamentos as $d)
                                <tr>
                                    <td>{{ $d->nombre }}</td>
                                    <td>
                                        @foreach ($d->puestos as $p)
                                            <span class="badge text-bg-secondary">{{ $p->nombre }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $d->empleados_count }}</td>
                                    @if (Auth::user()->esAdmin())
                                        <td>
                                            <a href="{{ route('departamentos.edit', $d) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('departamentos.destroy', $d) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Eliminar este departamento?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-secondary py-4">No hay departamentos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
