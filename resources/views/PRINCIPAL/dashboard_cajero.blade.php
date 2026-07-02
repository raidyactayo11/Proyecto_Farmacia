@extends('PLANTILLA.administrador')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Dashboard Cajero</h1>
        <p class="text-muted mb-0">Panel operativo para registrar ventas y consultar actividad reciente</p>
    </div>

    <a href="{{ route('ventas.index') }}" class="btn btn-primary">
        <i class="bi bi-cart-plus"></i>
        Registrar venta
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Ventas registradas</p>
                <h3 class="mb-0">{{ $totalVentas }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Monto total vendido</p>
                <h3 class="text-success mb-0">S/ {{ number_format($montoTotalVentas, 2) }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <p class="text-muted mb-1">Medicamentos con bajo stock</p>
                <h3 class="text-danger mb-0">{{ $medicamentosBajoStock }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Últimas ventas</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ventasRecientes as $venta)
                        <tr>
                            <td>#{{ $venta->id }}</td>
                            <td>{{ $venta->cliente->nombre ?? 'Cliente eliminado' }}</td>
                            <td>S/ {{ number_format($venta->total, 2) }}</td>
                            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Todavía no hay ventas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
