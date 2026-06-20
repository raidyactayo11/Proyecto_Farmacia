@extends('PLANTILLA.administrador')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Productos</h3>
    </div>

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERRORES --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO CREAR --}}
    <form action="{{ route('productos.store') }}" method="POST" class="mb-3">
        @csrf

        <div class="row">
            <div class="col">
                <input type="text" name="nombre" class="form-control" placeholder="Nombre">
            </div>

            <div class="col">
                <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio">
            </div>

            <div class="col">
                <input type="number" name="stock" class="form-control" placeholder="Stock">
            </div>

            <div class="col">
                <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
            </div>

            <div class="col">
                <button class="btn btn-success">
                    Guardar
                </button>
            </div>
        </div>
    </form>

    {{-- TABLA --}}
    <div class="card">
        <div class="card-body">

            <table class="table table-hover">
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
                    @foreach($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->precio }}</td>
                            <td>{{ $producto->stock }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>

                                {{-- BOTÓN EDITAR --}}
                                <button class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditar{{ $producto->id }}">
                                    Editar
                                </button>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('productos.destroy', $producto->id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Eliminar producto?')">
                                        Eliminar
                                    </button>
                                </form>

                            </td>
                        </tr>

                        {{-- MODAL EDITAR --}}
                        <div class="modal fade" id="modalEditar{{ $producto->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Producto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <div class="mb-2">
                                                <label>Nombre</label>
                                                <input type="text" name="nombre" class="form-control"
                                                       value="{{ $producto->nombre }}">
                                            </div>

                                            <div class="mb-2">
                                                <label>Precio</label>
                                                <input type="number" step="0.01" name="precio" class="form-control"
                                                       value="{{ $producto->precio }}">
                                            </div>

                                            <div class="mb-2">
                                                <label>Stock</label>
                                                <input type="number" name="stock" class="form-control"
                                                       value="{{ $producto->stock }}">
                                            </div>

                                            <div class="mb-2">
                                                <label>Descripción</label>
                                                <input type="text" name="descripcion" class="form-control"
                                                       value="{{ $producto->descripcion }}">
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>

                                            <button type="submit" class="btn btn-primary">
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

@endsection