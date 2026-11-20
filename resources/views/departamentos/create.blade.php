<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Departamentos</h1>
    </x-slot>

    <section class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header bg-dark text-white">Nuevo departamento</div>
                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('departamentos.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="puestos" class="form-label">Puestos (uno por línea)</label>
                            <textarea class="form-control @error('puestos') is-invalid @enderror" id="puestos" name="puestos" rows="5" required>{{ old('puestos') }}</textarea>
                            @error('puestos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('departamentos.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
