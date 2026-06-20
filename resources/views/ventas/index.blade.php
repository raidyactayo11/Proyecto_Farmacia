@extends('PLANTILLA.administrador')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Gestión de Ventas</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO --}}
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Registrar nueva venta
        </div>

        <div class="card-body">

            <form action="{{ route('ventas.store') }}" method="POST">
                @csrf

                {{-- CLIENTE --}}
                <div class="mb-3">
                    <label>Cliente</label>
                    <select id="cliente" name="cliente_id" class="form-select" required>
                        <option value="">Seleccione cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- MEDICAMENTO --}}
                <div class="row">
                    <div class="col-md-5">
                        <label>Medicamento</label>
                        <select id="medicamento" class="form-select">
                            <option value="">Seleccione</option>
                            @foreach($medicamentos as $m)
                                <option value="{{ $m->id }}"
                                        data-nombre="{{ $m->nombre }}"
                                        data-precio="{{ $m->precio }}"
                                        data-stock="{{ $m->stock }}">
                                    {{ $m->nombre }} (Stock: {{ $m->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Cantidad</label>
                        <input type="number" id="cantidad" class="form-control" min="1">
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-success w-100" onclick="agregar()">
                            Agregar
                        </button>
                    </div>
                </div>

                {{-- TABLA TEMPORAL --}}
                <div class="mt-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Medicamento</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody id="tabla"></tbody>
                    </table>
                </div>

                {{-- TOTAL --}}
                <h4>Total: S/ <span id="total">0.00</span></h4>

                <button type="submit" class="btn btn-primary mt-3">
                    Registrar Venta
                </button>

            </form>

        </div>
    </div>

    {{-- HISTORIAL --}}
    <div class="card mt-4">
        <div class="card-header bg-dark text-white">
            Historial de Ventas
        </div>

        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Medicamentos</th>
                        <th>Total</th>
                        <th>Fecha</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($ventas as $v)
    <tr>
        <td>{{ $v->id }}</td>
        <td>{{ $v->cliente->nombre }}</td>

        <td>
            @foreach($v->detalles as $d)
                {{ $d->medicamento->nombre }} ({{ $d->cantidad }}) <br>
            @endforeach
        </td>

        <td>S/ {{ number_format($v->total,2) }}</td>
        <td>{{ $v->fecha }}</td>

        
        <td>
            <form id="delete-form-{{ $v->id }}" action="{{ route('ventas.destroy', $v->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="button"
                class="btn btn-outline-danger btn-sm"
                onclick="confirmDelete({{ $v->id }})">

                🗑 Eliminar
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

{{-- JS --}}
<script>

let carrito = [];
let total = 0;

function agregar() {

    let select = document.getElementById("medicamento");
    let option = select.options[select.selectedIndex];

    let id = option.value;
    let nombre = option.dataset.nombre;
    let precio = parseFloat(option.dataset.precio);
    let stock = parseInt(option.dataset.stock);
    let cantidad = parseInt(document.getElementById("cantidad").value);

    if(!id || !cantidad || cantidad <= 0) return;

    if(cantidad > stock) {
        alert("Stock insuficiente");
        return;
    }

    let subtotal = precio * cantidad;

    carrito.push({id, nombre, precio, cantidad, subtotal});

    render();
}

function render() {

    let tabla = document.getElementById("tabla");
    tabla.innerHTML = "";
    total = 0;

    carrito.forEach((item, index) => {

        total += item.subtotal;

        tabla.innerHTML += `
        <tr>
            <td>
                ${item.nombre}
                <input type="hidden" name="medicamento_id[]" value="${item.id}">
            </td>

            <td>
                ${item.cantidad}
                <input type="hidden" name="cantidad[]" value="${item.cantidad}">
            </td>

            <td>${item.precio}</td>
            <td>${item.subtotal.toFixed(2)}</td>

            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminar(${index})">
                    X
                </button>
            </td>
        </tr>
        `;
    });

    document.getElementById("total").innerText = total.toFixed(2);
}

function eliminar(index) {
    carrito.splice(index, 1);
    render();
}

</script>

{{-- SweetAlert2 SIEMPRE aparte --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id) {

    Swal.fire({
        title: "¿Eliminar venta?",
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