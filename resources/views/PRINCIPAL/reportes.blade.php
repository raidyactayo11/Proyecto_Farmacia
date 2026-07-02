@extends('PLANTILLA.administrador')

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <h1 class="h3 mb-1">Reportes</h1>
        <p class="text-muted mb-0">Consulta información importante del sistema</p>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('reportes.medicamentos.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i>
            PDF Medicamentos
        </a>

        <a href="{{ route('reportes.ventas.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i>
            PDF Ventas
        </a>

        <a href="{{ route('reportes.clientes.pdf') }}" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf"></i>
            PDF Clientes
        </a>

        <a href="{{ route('reportes.medicamentos.excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i>
            Excel Medicamentos
        </a>

        <a href="{{ route('reportes.ventas.excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i>
            Excel Ventas
        </a>

        <a href="{{ route('reportes.clientes.excel') }}" class="btn btn-success">
            <i class="bi bi-file-earmark-excel"></i>
            Excel Clientes
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Reporte de ventas</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="tablaVentasReporte" class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                        <tr>
                            <td>#{{ $venta->id }}</td>
                            <td>{{ $venta->cliente->nombre ?? 'Cliente eliminado' }}</td>
                            <td>S/ {{ number_format($venta->total, 2) }}</td>
                            <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">Medicamentos con bajo stock</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="tablaStockReporte" class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>Medicamento</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medicamentosBajoStock as $medicamento)
                        <tr>
                            <td>{{ $medicamento->nombre }}</td>
                            <td>{{ $medicamento->categoria->nombre ?? 'Sin categoría' }}</td>
                            <td>
                                <span class="badge text-bg-danger">
                                    {{ $medicamento->stock }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Clientes con ventas registradas</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="tablaClientesReporte" class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>DNI</th>
                        <th>Cantidad de ventas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientesConVentas as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->dni }}</td>
                            <td>{{ $cliente->ventas_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#tablaVentasReporte').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.8/i18n/es-ES.json'
            }
        });

        $('#tablaStockReporte').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.8/i18n/es-ES.json'
            }
        });

        $('#tablaClientesReporte').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.8/i18n/es-ES.json'
            }
        });
    });
</script>
@endsection
