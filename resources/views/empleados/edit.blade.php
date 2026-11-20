<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Empleados</h1>
    </x-slot>

    <section class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header bg-dark text-white">Editar empleado</div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('empleados.update', $empleado) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $empleado->nombre) }}" required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido', $empleado->apellido) }}" required>
                                @error('apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control @error('correo') is-invalid @enderror" id="correo" name="correo" value="{{ old('correo', $empleado->correo) }}" required>
                            @error('correo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="puesto_id" class="form-label">Puesto</label>
                            <select class="form-select @error('puesto_id') is-invalid @enderror" id="puesto_id" name="puesto_id" required>
                                <option value="">Seleccione un puesto</option>
                                @foreach ($departamentos as $d)
                                    <optgroup label="{{ $d->nombre }}">
                                        @foreach ($d->puestos as $p)
                                            <option value="{{ $p->id }}" @selected(old('puesto_id', $empleado->puesto_id) == $p->id)>{{ $p->nombre }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('puesto_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
