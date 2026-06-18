@extends('PLANTILLA.administrador')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Productos</h3>
    </div>

    {{-- FORMULARIO --}}
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

            {{-- ✔ DESCRIPCIÓN AGREGADA --}}
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
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Descripción</th> {{-- ✔ AGREGADO --}}
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
                            <td>{{ $producto->descripcion }}</td> {{-- ✔ AGREGADO --}}
                            <td>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Eliminar producto?')">
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

@endsection