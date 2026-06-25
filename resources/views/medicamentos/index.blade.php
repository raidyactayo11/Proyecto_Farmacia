@extends('PLANTILLA.administrador')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-1">Medicamentos</h3>
            <p class="text-muted mb-0">Administra el catálogo, precios y existencias.</p>
        </div>

        <a href="{{ route('medicamentos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nuevo medicamento
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaMedicamentos" class="table table-hover table-striped align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Slug</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($medicamentos as $medicamento)
                            <tr>
                                <td>{{ $medicamento->id }}</td>
                                <td>
                                    @if($medicamento->imagen)
                                        <img
                                            src="{{ asset('storage/' . $medicamento->imagen) }}"
                                            alt="Imagen de {{ $medicamento->nombre }}"
                                            class="rounded border"
                                            style="width: 56px; height: 56px; object-fit: cover;">
                                    @else
                                        <span class="badge text-bg-light">Sin imagen</span>
                                    @endif
                                </td>
                                <td>{{ $medicamento->nombre }}</td>
                                <td>{{ optional($medicamento->categoria)->nombre ?? 'Sin categoría' }}</td>
                                <td><code>{{ $medicamento->slug }}</code></td>
                                <td>S/ {{ number_format($medicamento->precio, 2) }}</td>
                                <td>
                                    <span class="badge {{ $medicamento->stock <= 5 ? 'text-bg-danger' : 'text-bg-success' }}">
                                        {{ $medicamento->stock }}
                                    </span>
                                </td>
                                <td>{{ $medicamento->descripcion }}</td>
                                <td class="text-nowrap">
                                    <a
                                        href="{{ route('medicamentos.edit', $medicamento) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                        Editar
                                    </a>

                                    <form
                                        action="{{ route('medicamentos.destroy', $medicamento) }}"
                                        method="POST"
                                        class="d-inline form-eliminar"
                                        data-nombre="el medicamento {{ $medicamento->nombre }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i>
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new DataTable('#tablaMedicamentos', {
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [[0, 'desc']],
            columnDefs: [
                {
                    targets: [1, 8],
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                search: 'Buscar medicamento:',
                lengthMenu: 'Mostrar _MENU_ medicamentos',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ medicamentos',
                infoEmpty: 'No hay medicamentos registrados',
                infoFiltered: '(filtrado de _MAX_ registros)',
                zeroRecords: 'No se encontraron medicamentos',
                emptyTable: 'No hay medicamentos disponibles',
                paginate: {
                    first: 'Primero',
                    last: 'Último',
                    next: 'Siguiente',
                    previous: 'Anterior'
                }
            }
        });
    });
</script>
@endsection
