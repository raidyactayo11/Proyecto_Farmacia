@extends('PLANTILLA.administrador')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Clientes</h3>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
            Nuevo Cliente
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLA --}}
    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->id }}</td>
                <td>{{ $cliente->nombre }}</td>
                <td>{{ $cliente->dni }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>{{ $cliente->direccion }}</td>

                <td>
                    {{-- EDITAR --}}
                    <button class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditar{{ $cliente->id }}">
                        Editar
                    </button>

                    {{-- ELIMINAR --}}
                    <form id="delete-form-{{ $cliente->id }}" action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')

                        <button type="button"
                            class="btn btn-danger btn-sm"
                            onclick="confirmDelete({{ $cliente->id }})">

                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>

            {{-- MODAL EDITAR --}}
            <div class="modal fade" id="modalEditar{{ $cliente->id }}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h5 class="modal-title">Editar Cliente</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                <input type="text" name="nombre" class="form-control mb-2" value="{{ $cliente->nombre }}">
                                <input type="text" name="dni" class="form-control mb-2" value="{{ $cliente->dni }}">
                                <input type="text" name="telefono" class="form-control mb-2" value="{{ $cliente->telefono }}">
                                <input type="text" name="direccion" class="form-control mb-2" value="{{ $cliente->direccion }}">

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button class="btn btn-primary">Guardar</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            @endforeach
        </tbody>
    </table>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrear">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Cliente</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre">
                    <input type="text" name="dni" class="form-control mb-2" placeholder="DNI">
                    <input type="text" name="telefono" class="form-control mb-2" placeholder="Teléfono">
                    <input type="text" name="direccion" class="form-control mb-2" placeholder="Dirección">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-success">Guardar</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id) {

    Swal.fire({
        title: "¿Eliminar cliente?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {

        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }

    });

}
</script>

@endsection