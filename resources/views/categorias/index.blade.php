@extends('PLANTILLA.administrador')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-1">Categorías</h3>
            <p class="text-muted mb-0">Administra la clasificación del catálogo.</p>
        </div>

        <a href="{{ route('categorias.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Nueva categoría
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaCategorias" class="table table-hover table-striped align-middle w-100">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Medicamentos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->id }}</td>
                                <td>{{ $categoria->nombre }}</td>
                                <td>{{ $categoria->descripcion }}</td>
                                <td>
                                    <span class="badge text-bg-secondary">
                                        {{ $categoria->medicamentos_count }}
                                    </span>
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('categorias.edit', $categoria) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-square"></i>
                                        Editar
                                    </a>

                                    <form
                                        action="{{ route('categorias.destroy', $categoria) }}"
                                        method="POST"
                                        class="d-inline form-eliminar"
                                        data-nombre="la categoría {{ $categoria->nombre }}">
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
        new DataTable('#tablaCategorias', {
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [[0, 'desc']],
            columnDefs: [
                {
                    targets: 4,
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                search: 'Buscar categoría:',
                lengthMenu: 'Mostrar _MENU_ categorías',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ categorías',
                infoEmpty: 'No hay categorías registradas',
                infoFiltered: '(filtrado de _MAX_ registros)',
                zeroRecords: 'No se encontraron categorías',
                emptyTable: 'No hay categorías disponibles',
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
