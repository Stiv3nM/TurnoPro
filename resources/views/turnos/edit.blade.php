<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Turnos</h1>
    </x-slot>

    <section class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header bg-dark text-white">Editar turno</div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('turnos.update', $turno) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $turno->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <select class="form-select @error('tipo') is-invalid @enderror" id="tipo" name="tipo" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="AM" @selected(old('tipo', $turno->tipo) == 'AM')>AM (mañana)</option>
                                <option value="MID" @selected(old('tipo', $turno->tipo) == 'MID')>MID (medio)</option>
                                <option value="PM" @selected(old('tipo', $turno->tipo) == 'PM')>PM (tarde)</option>
                            </select>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="hora_inicio" class="form-label">Hora de inicio</label>
                                <input type="time" class="form-control @error('hora_inicio') is-invalid @enderror" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio', substr($turno->hora_inicio, 0, 5)) }}" required>
                                @error('hora_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="hora_fin" class="form-label">Hora de fin</label>
                                <input type="time" class="form-control @error('hora_fin') is-invalid @enderror" id="hora_fin" name="hora_fin" value="{{ old('hora_fin', substr($turno->hora_fin, 0, 5)) }}" required>
                                @error('hora_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('turnos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
