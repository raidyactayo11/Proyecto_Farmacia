@extends('PLANTILLA.administrador')

@section('content')
<div class="container mt-4">
    <div class="mb-3">
        <h3 class="mb-1">Editar cliente</h3>
        <p class="text-muted mb-0">Actualiza los datos de {{ $cliente->nombre }}.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                @csrf
                @method('PUT')
                @include('clientes._form')
            </form>
        </div>
    </div>
</div>
@endsection
