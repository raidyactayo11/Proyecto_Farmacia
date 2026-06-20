<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FARMACIA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        .menu-link{
            color:#495057;
            text-decoration:none;
            padding:10px 15px;
            border-radius:8px;
            display:block;
            margin-bottom:5px;
            transition:.2s;
        }

        .menu-link:hover{
            background-color:var(--bs-primary);
            color:#fff;
        }

        .menu-link.active{
            background-color:var(--bs-primary);
            color:#fff;
        }

        .sidebar{
            min-height:100vh;
        }
    </style>
</head>

<body>

<div class="row g-0">

    {{-- SIDEBAR --}}
    <aside class="col-md-3 col-lg-2 bg-white border-end sidebar">

        <div class="p-3">

            <h4 class="fw-bold text-primary small text-center text-uppercase">
                Farmacia San Juan
            </h4>

            <hr>

            <div class="text-center mb-4">
                <img
                    src=""
                    style="width:100px;height:100px;background:#a3a3a3;border-radius:50%;"
                >

                <h6 class="mt-2">
                    Administrador
                </h6>

                <span class="badge text-bg-primary">
                    General
                </span>
            </div>

            {{-- PRINCIPAL --}}
            <h6 class="text-muted fw-bold">
                PRINCIPAL
            </h6>

            <nav>

                <a href="{{ route('dashboard.index') }}"
                   class="menu-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>

                <a href="{{ route('configuraciones.index') }}"
                   class="menu-link {{ request()->routeIs('configuraciones.index') ? 'active' : '' }}">
                    <i class="bi bi-gear me-2"></i>
                    Configuraciones
                </a>

                <a href="#"
                   class="menu-link">
                    <i class="bi bi-bar-chart me-2"></i>
                    Reportes
                </a>

            </nav>

            {{-- GESTIÓN --}}
            <h6 class="text-muted fw-bold mt-4">
                GESTIÓN
            </h6>

            <nav>

                <a href="{{ route('clientes.index') }}"
                   class="menu-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i>
                    Clientes
                </a>

                <a href="{{ route('medicamentos.index') }}"
                   class="menu-link {{ request()->routeIs('medicamentos.*') ? 'active' : '' }}">
                    <i class="bi bi-capsule me-2"></i>
                    Medicamentos
                </a>

                <a href="{{ route('ventas.index') }}"
                    class="menu-link {{ request()->routeIs('ventas.*') ? 'active' : '' }}">
                    <i class="bi bi-cart me-2"></i>
                    Ventas
                </a>

            </nav>

        </div>

    </aside>

    {{-- CONTENIDO --}}
    <main class="col-md-9 col-lg-10">

        <nav class="navbar navbar-expand-lg bg-white border-bottom">

            <div class="container-fluid justify-content-end">

                <a href="#" class="btn btn-outline-secondary position-relative me-3">
                    <i class="bi bi-bell"></i>

                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        99
                    </span>
                </a>

                <div class="dropdown">

                    <button
                        class="btn btn-secondary dropdown-toggle"
                        data-bs-toggle="dropdown">

                        Raid RRY

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a class="dropdown-item" href="#">
                                Mi Perfil
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">
                                Mis notificaciones
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">
                                Cerrar sesión
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        </nav>

        <div class="p-4">

            @yield('content')

        </div>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

@yield('scripts')

</body>
</html>