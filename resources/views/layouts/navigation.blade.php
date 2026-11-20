<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">TurnoPro</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Mostrar menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Resumen</a>
                </li>
                @if (Auth::user()->esAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('departamentos.*') ? 'active' : '' }}" href="{{ route('departamentos.index') }}">Departamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('empleados.*') ? 'active' : '' }}" href="{{ route('empleados.index') }}">Empleados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('turnos.*') ? 'active' : '' }}" href="{{ route('turnos.index') }}">Turnos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('horarios.*') ? 'active' : '' }}" href="{{ route('horarios.index') }}">Horarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('requerimientos.*') ? 'active' : '' }}" href="{{ route('requerimientos.index') }}">Requerimientos</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mi.horario') ? 'active' : '' }}" href="{{ route('mi.horario') }}">Mi horario</a>
                    </li>
                @endif
            </ul>

            <span class="navbar-text me-3">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
            </form>
        </div>
    </div>
</nav>