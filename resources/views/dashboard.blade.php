<x-app-layout>
    <x-slot name="header">
        <h1 class="h3 mb-0">Resumen</h1>
    </x-slot>

    @php
        $totalEmpleados = \App\Models\Empleado::count();
        $totalDepartamentos = \App\Models\Departamento::count();
        $totalTurnos = \App\Models\Turno::count();
        $totalHorarios = \App\Models\Horario::count();
    @endphp

    <section>
        <h2 class="h5 mb-4">Bienvenido, {{ Auth::user()->name }}</h2>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6 card-title text-secondary">Empleados</h3>
                        <p class="display-6 mb-2">{{ $totalEmpleados }}</p>
                        <a href="{{ route('empleados.index') }}" class="btn btn-sm btn-gris">Ver empleados</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6 card-title text-secondary">Departamentos</h3>
                        <p class="display-6 mb-2">{{ $totalDepartamentos }}</p>
                        <a href="{{ route('departamentos.index') }}" class="btn btn-sm btn-gris">Ver departamentos</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6 card-title text-secondary">Turnos</h3>
                        <p class="display-6 mb-2">{{ $totalTurnos }}</p>
                        <a href="{{ route('turnos.index') }}" class="btn btn-sm btn-gris">Ver turnos</a>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card text-center">
                    <div class="card-body">
                        <h3 class="h6 card-title text-secondary">Horarios</h3>
                        <p class="display-6 mb-2">{{ $totalHorarios }}</p>
                        <a href="{{ route('horarios.index') }}" class="btn btn-sm btn-gris">Ver horarios</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>