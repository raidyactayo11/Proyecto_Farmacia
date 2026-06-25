@extends('PLANTILLA.administrador')

@section('content')
<div class="container mt-4">
    <div class="mb-3">
        <h3 class="mb-1">Nuevo cliente</h3>
        <p class="text-muted mb-0">Registra los datos de identificación del cliente.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                @include('clientes._form')
            </form>
        </div>
    </div>
</div>
@endsection
