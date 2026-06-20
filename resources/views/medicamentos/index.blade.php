@extends('PLANTILLA.administrador')

@section('content')

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Medicamentos</h3>

        {{-- BOTÓN NUEVO --}}
        <button class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modalCrear">
            Nuevo Medicamento
        </button>
    </div>

    {{-- MENSAJE ÉXITO --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERRORES --}}
   @if($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error en el formulario',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
        </script>
    @endif

    {{-- BUSCADOR --}}
    <input type="text" id="buscar" class="form-control mb-3"
           placeholder="Buscar medicamento...">

    {{-- TABLA --}}
    <div class="card">
        <div class="card-body">

            <table class="table table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
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
                            <td>{{ $medicamento->nombre }}</td>
                            <td>{{ $medicamento->precio }}</td>
                            <td>{{ $medicamento->stock }}</td>
                            <td>{{ $medicamento->descripcion }}</td>

                            <td>

                                {{-- BOTÓN EDITAR --}}
                                <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditar{{ $medicamento->id }}">
                                    Editar
                                </button>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('medicamentos.destroy', $medicamento->id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Eliminar medicamento?')">
                                        Eliminar
                                    </button>
                                </form>

                            </td>
                        </tr>

                        {{-- MODAL EDITAR --}}
                        <div class="modal fade" id="modalEditar{{ $medicamento->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="{{ route('medicamentos.update', $medicamento->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Medicamento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-2">
                                                <label>Nombre</label>
                                                <input type="text" name="nombre" class="form-control"
                                                       value="{{ $medicamento->nombre }}">
                                            </div>

                                            <div class="mb-2">
                                                <label>Precio</label>
                                                <input type="number" step="0.01" name="precio" class="form-control"
                                                       value="{{ $medicamento->precio }}">
                                            </div>

                                            <div class="mb-2">
                                                <label>Stock</label>
                                                <input type="number" name="stock" class="form-control"
                                                       value="{{ $medicamento->stock }}">
                                            </div>

                                            <div class="mb-2">
                                                <label>Descripción</label>
                                                <input type="text" name="descripcion" class="form-control"
                                                       value="{{ $medicamento->descripcion }}">
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>

                                            <button class="btn btn-primary">
                                                Guardar cambios
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrear" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('medicamentos.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Medicamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-2">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Stock</label>
                        <input type="number" name="stock" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Descripción</label>
                        <input type="text" name="descripcion" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button class="btn btn-success">
                        Guardar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- BUSCADOR JS --}}
<script>
document.getElementById("buscar").addEventListener("keyup", function() {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        row.style.display =
            row.innerText.toLowerCase().includes(value)
            ? ""
            : "none";
    });
});
</script>



@if($errors->any())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if($errors->any())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
Swal.fire({
    icon: 'error',
    title: 'Error en el formulario',
    html: `{!! implode('<br>', $errors->all()) !!}`
});
</script>
@endif

</script>
@endif

@endsection