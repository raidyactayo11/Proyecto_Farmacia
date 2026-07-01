@extends('PLANTILLA.administrador')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Configuraciones</h1>
        <p class="text-muted mb-0">Accesos rápidos para administrar el sistema</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="bg-primary-subtle text-primary rounded-circle p-3 d-inline-block mb-3">
                    <i class="bi bi-tags fs-4"></i>
                </div>

                <h5>Categorías</h5>
                <p class="text-muted">
                    Administra los grupos de medicamentos.
                </p>

                <a href="{{ route('categorias.index') }}" class="btn btn-primary">
                    Ir a categorías
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="bg-success-subtle text-success rounded-circle p-3 d-inline-block mb-3">
                    <i class="bi bi-capsule fs-4"></i>
                </div>

                <h5>Medicamentos</h5>
                <p class="text-muted">
                    Controla productos, precios y stock.
                </p>

                <a href="{{ route('medicamentos.index') }}" class="btn btn-success">
                    Ir a medicamentos
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="bg-info-subtle text-info rounded-circle p-3 d-inline-block mb-3">
                    <i class="bi bi-people fs-4"></i>
                </div>

                <h5>Clientes</h5>
                <p class="text-muted">
                    Gestiona los datos de tus clientes.
                </p>

                <a href="{{ route('clientes.index') }}" class="btn btn-info text-white">
                    Ir a clientes
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="bg-warning-subtle text-warning rounded-circle p-3 d-inline-block mb-3">
                    <i class="bi bi-cart fs-4"></i>
                </div>

                <h5>Ventas</h5>
                <p class="text-muted">
                    Registra ventas y controla el stock.
                </p>

                <a href="{{ route('ventas.index') }}" class="btn btn-warning text-white">
                    Ir a ventas
                </a>
            </div>
        </div>
    </div>
</div>
@endsection