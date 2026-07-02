@extends('PLANTILLA.administrador')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Dashboard</h1>
        <p class="text-muted mb-0">Resumen gerencial del sistema de farmacia</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Categorías</p>
                        <h3 class="mb-0">{{ $totalCategorias }}</h3>
                    </div>
                    <div class="bg-primary-subtle text-primary rounded-circle p-3">
                        <i class="bi bi-tags fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Medicamentos</p>
                        <h3 class="mb-0">{{ $totalMedicamentos }}</h3>
                    </div>
                    <div class="bg-success-subtle text-success rounded-circle p-3">
                        <i class="bi bi-capsule fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Clientes</p>
                        <h3 class="mb-0">{{ $totalClientes }}</h3>
                    </div>
                    <div class="bg-info-subtle text-info rounded-circle p-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Ventas</p>
                        <h3 class="mb-0">{{ $totalVentas }}</h3>
                    </div>
                    <div class="bg-warning-subtle text-warning rounded-circle p-3">
                        <i class="bi bi-cart me-0 fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <p class="text-muted mb-1">Monto total vendido</p>
                <h2 class="text-success mb-3">
                    S/ {{ number_format($montoTotalVentas, 2) }}
                </h2>

                <p class="text-muted mb-1">Medicamentos con bajo stock</p>
                <h2 class="text-danger mb-0">{{ $medicamentosBajoStock }}</h2>
                <small class="text-muted">Stock menor o igual a 5 unidades</small>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ventas por día</h5>
            </div>
            <div class="card-body">
                <canvas id="graficoVentasPorDia" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Medicamentos con menor stock</h5>
            </div>
            <div class="card-body">
                <canvas id="graficoStockMedicamentos" height="160"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="mb-0">Ventas por cliente</h5>
            </div>
            <div class="card-body">
                <canvas id="graficoVentasPorCliente" height="160"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Últimas ventas registradas</h5>
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

@section('scripts')
<script>
    const ventasPorDia = @json($ventasPorDia);
    const stockMedicamentos = @json($stockMedicamentos);
    const ventasPorCliente = @json($ventasPorCliente);

    new Chart(document.getElementById('graficoVentasPorDia'), {
        type: 'bar',
        data: {
            labels: ventasPorDia.map(item => item.fecha),
            datasets: [{
                label: 'Total vendido',
                data: ventasPorDia.map(item => Number(item.total)),
                backgroundColor: '#0d6efd'
            }]
        }
    });

    new Chart(document.getElementById('graficoStockMedicamentos'), {
        type: 'bar',
        data: {
            labels: stockMedicamentos.map(item => item.nombre),
            datasets: [{
                label: 'Stock',
                data: stockMedicamentos.map(item => Number(item.stock)),
                backgroundColor: '#dc3545'
            }]
        },
        options: {
            indexAxis: 'y'
        }
    });

    new Chart(document.getElementById('graficoVentasPorCliente'), {
        type: 'doughnut',
        data: {
            labels: ventasPorCliente.map(item => item.cliente ? item.cliente.nombre : 'Cliente eliminado'),
            datasets: [{
                label: 'Total vendido',
                data: ventasPorCliente.map(item => Number(item.total)),
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1']
            }]
        }
    });
</script>
@endsection
