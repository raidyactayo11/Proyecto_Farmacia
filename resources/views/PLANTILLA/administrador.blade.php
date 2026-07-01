<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmacia San Juan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.8/css/dataTables.bootstrap5.min.css">

    <style>
        .menu-link {
            color: #495057;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            display: block;
            margin-bottom: 5px;
            transition: .2s;
        }

        .menu-link:hover,
        .menu-link.active {
            background-color: var(--bs-primary);
            color: #fff;
        }

        .sidebar {
            min-height: 100vh;
        }
    </style>

    @yield('styles')
</head>

<body>
<div class="row g-0">
    <aside class="col-md-3 col-lg-2 bg-white border-end sidebar">
        <div class="p-3">
            <h4 class="fw-bold text-primary small text-center text-uppercase">
                Farmacia San Juan
            </h4>

            <hr>

            <div class="text-center mb-4">
                <div
                    class="mx-auto bg-secondary-subtle rounded-circle"
                    style="width: 100px; height: 100px;"
                    aria-label="Avatar del administrador">
                </div>

                <h6 class="mt-2">Administrador</h6>
                <span class="badge text-bg-primary">General</span>
            </div>

            <h6 class="text-muted fw-bold">PRINCIPAL</h6>

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

                <a href="{{ route('reportes.index') }}"
                    class="menu-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart me-2"></i>
                    Reportes
                </a>
            </nav>

            <h6 class="text-muted fw-bold mt-4">GESTIÓN</h6>

            <nav>
                <a href="{{ route('categorias.index') }}"
                   class="menu-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                    <i class="bi bi-tags me-2"></i>
                    Categorías
                </a>

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
                        type="button"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Raid RRY
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Mi perfil</a></li>
                        <li><a class="dropdown-item" href="#">Mis notificaciones</a></li>
                        <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Operación exitosa',
                text: @json(session('success')),
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#0d6efd'
            });
        });
    </script>
@endif

@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Ocurrió un problema',
                text: @json(session('error')),
                confirmButtonText: 'Aceptar'
            });
        });
    </script>
@endif

@if($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const errores = @json($errors->all());
            const lista = errores
                .map(error => `<li>${escapeHtml(error)}</li>`)
                .join('');

            Swal.fire({
                icon: 'error',
                title: 'Revisa los datos ingresados',
                html: `<ul class="text-start mb-0">${lista}</ul>`,
                confirmButtonText: 'Corregir'
            });
        });
    </script>
@endif

<script>
    function escapeHtml(texto) {
        const elemento = document.createElement('div');
        elemento.textContent = texto;
        return elemento.innerHTML;
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.form-eliminar').forEach(function (formulario) {
            formulario.addEventListener('submit', function (evento) {
                evento.preventDefault();

                const nombre = formulario.dataset.nombre || 'este registro';

                Swal.fire({
                    icon: 'warning',
                    title: '¿Confirmar eliminación?',
                    text: `Vas a eliminar ${nombre}. Esta acción no se puede deshacer.`,
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    reverseButtons: true
                }).then(function (resultado) {
                    if (resultado.isConfirmed) {
                        formulario.submit();
                    }
                });
            });
        });
    });
</script>

@yield('scripts')
</body>
</html>
