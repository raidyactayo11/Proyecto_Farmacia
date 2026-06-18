<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FARMACIA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .menu-link{
            color: #495057;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 8px;
            display: block;
            margin-bottom: 5px;
        }

        .menu-link:hover{
            background-color: var(--bs-primary);
            color: white;
        }

        .menu-link.active{
            background-color: var(--bs-primary);
            color: white;
        }
    </style>
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
                    <img src="" alt="" style="width: 100px; height: 100px; background-color: #a3a3a3; border-radius: 50%;">
                    <h6>Administrador</h6>
                    <span class="badge text-bg-primary">
                        General
                    </span>
                </div>

                <h6 class="text-muted fw-bold">PRINCIPAL</h6>
                <nav>
                    <a href="{{ route('dashboard.index') }}" class="menu-link {{ request()->is(['/'])? 'active' : null }}">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('configuraciones.index') }}" class="menu-link {{ request()->is(['configuraciones'])? 'active' : null }}">
                        <i class="bi bi-gear me-2"></i>
                        Configuraciones
                    </a>
                    <a href="" class="menu-link">
                        <i class="bi bi-bar-chart me-2"></i>
                        Reportes
                    </a>
                </nav>
                <h6 class="text-muted fw-bold">GESTIÓN</h6>
                <nav>
                    <a href="" class="menu-link">
                        <i class="bi bi-people me-2"></i>
                        Clientes
                    </a>
                    <a href="" class="menu-link">
                        <i class="bi bi-capsule me-2"></i>
                        Medicamentos
                    </a>
                    <a href="" class="menu-link">
                        <i class="bi bi-cart me-2"></i>
                        Ventas
                    </a>
                </nav>

            </div>
        </aside>
        <main class="col-md-9 col-lg-10">
            <nav class="navbar navbar-expand-lg bg-white border-bottom">
                <div class="ms-auto d-flex align-items-center gap-3">
                    <a href="" class="btn btn-outline-secondary position-relative">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-danger small">99</span>
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Raid RRY
                        </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
                        <li><a class="dropdown-item" href="#">Mis notificaciones</a></li>
                        <li><a class="dropdown-item" href="#">Cerrar sesión</a></li>
                    </ul>
                    </div>
                </div>
            </nav>

            @yield('content')
  
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>
</html>