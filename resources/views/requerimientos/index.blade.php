<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Requerimientos</h1>
    </x-slot>

    @php $nombresDias = ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom']; @endphp

    <section class="row justify-content-center">
        <div class="col-lg-11">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (!$departamento)
                <div class="alert alert-info">Primero crea un departamento.</div>
            @else
                <form method="GET" action="{{ route('requerimientos.index') }}" class="mb-4">
                    <label for="departamento_id" class="form-label">Departamento</label>
                    <select class="form-select" id="departamento_id" name="departamento_id" onchange="this.form.submit()">
                        @foreach ($departamentos as $d)
                            <option value="{{ $d->id }}" @selected($d->id == $departamento->id)>{{ $d->nombre }}</option>
                        @endforeach
                    </select>
                </form>

                <form method="POST" action="{{ route('requerimientos.store') }}">
                    @csrf

                    @foreach ($puestos as $puesto)
                        <div class="card mb-4">
                            <div class="card-header fw-semibold">{{ $puesto->nombre }} (personas necesarias por día)</div>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Turno</th>
                                            @foreach ($nombresDias as $dia)
                                                <th scope="col">{{ $dia }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (['AM', 'MID', 'PM'] as $tipo)
                                            <tr>
                                                <th scope="row">{{ $tipo }}</th>
                                                @foreach ($nombresDias as $i => $dia)
                                                    <td>
                                                        <input type="number" min="0" max="20"
                                                               name="r[{{ $puesto->id }}][{{ $tipo }}][{{ $i + 1 }}]"
                                                               value="{{ $cantidades[$puesto->id][$tipo][$i + 1] ?? 0 }}"
                                                               class="form-control form-control-sm text-center mx-auto" style="max-width: 80px;">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Guardar requerimientos</button>
                    </div>
                </form>
            @endif
        </div>
    </section>
</x-app-layout>
