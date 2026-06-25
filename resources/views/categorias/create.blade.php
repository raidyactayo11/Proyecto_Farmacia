@extends('PLANTILLA.administrador')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-1">Nueva categoría</h3>
            <p class="text-muted mb-0">Organiza los medicamentos por tipo o uso.</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('categorias.store') }}" method="POST">
                @csrf
                @include('categorias._form')
            </form>
        </div>
    </div>
</div>
@endsection
