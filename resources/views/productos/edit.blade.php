@extends('PLANTILLA.administrador')

@section('content')

<div class="container mt-4">

    <h3>Editar Producto</h3>

    <form action="{{ route('productos.update', $producto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="nombre" class="form-control mb-2" value="{{ $producto->nombre }}">

        <input type="number" name="precio" class="form-control mb-2" value="{{ $producto->precio }}">

        <input type="number" name="stock" class="form-control mb-2" value="{{ $producto->stock }}">

        <textarea name="descripcion" class="form-control mb-2">{{ $producto->descripcion }}</textarea>

        <button class="btn btn-success">Actualizar</button>

    </form>

</div>

@endsection