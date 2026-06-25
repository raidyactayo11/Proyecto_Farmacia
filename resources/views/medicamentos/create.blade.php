@extends('PLANTILLA.administrador')

@section('content')
<div class="container mt-4">
    <div class="mb-3">
        <h3 class="mb-1">Nuevo medicamento</h3>
        <p class="text-muted mb-0">Registra el medicamento y asígnalo a una categoría.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form
                action="{{ route('medicamentos.store') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf
                @include('medicamentos._form')
            </form>
        </div>
    </div>
</div>
@endsection
