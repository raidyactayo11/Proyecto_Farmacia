@extends('PLANTILLA.administrador')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Gestión de ventas</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            Registrar nueva venta
        </div>

        <div class="card-body">
            <form id="formVenta" action="{{ route('ventas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="cliente" class="form-label">Cliente</label>
                    <select id="cliente" name="cliente_id" class="form-select" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach($clientes as $cliente)
                            <option
                                value="{{ $cliente->id }}"
                                {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-3">
                    <div class="col-md-5">
                        <label for="medicamento" class="form-label">Medicamento</label>
                        <select id="medicamento" class="form-select">
                            <option value="">Seleccione un medicamento</option>
                            @foreach($medicamentos as $medicamento)
                                <option
                                    value="{{ $medicamento->id }}"
                                    data-nombre="{{ $medicamento->nombre }}"
                                    data-precio="{{ $medicamento->precio }}"
                                    data-stock="{{ $medicamento->stock }}">
                                    {{ $medicamento->nombre }} (stock: {{ $medicamento->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="cantidad" class="form-label">Cantidad</label>
                        <input type="number" id="cantidad" class="form-control" min="1">
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" class="btn btn-success w-100" id="btnAgregarMedicamento">
                            <i class="bi bi-plus-circle me-1"></i>
                            Agregar
                        </button>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Medicamento</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tablaDetalleVenta">
                            <tr id="filaCarritoVacio">
                                <td colspan="5" class="text-center text-muted">
                                    Todavía no has agregado medicamentos.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Total: S/ <span id="total">0.00</span></h4>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cart-check me-1"></i>
                        Registrar venta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header bg-dark text-white">
            Historial de ventas
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="tablaVentas" class="table table-bordered table-striped align-middle w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Medicamentos</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ventas as $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ optional($venta->cliente)->nombre ?? 'Cliente no disponible' }}</td>
                                <td>
                                    @foreach($venta->detalles as $detalle)
                                        <div>
                                            {{ optional($detalle->medicamento)->nombre ?? 'Medicamento no disponible' }}
                                            ({{ $detalle->cantidad }})
                                        </div>
                                    @endforeach
                                </td>
                                <td>S/ {{ number_format($venta->total, 2) }}</td>
                                <td>{{ $venta->fecha }}</td>
                                <td>
                                    <form
                                        action="{{ route('ventas.destroy', $venta->id) }}"
                                        method="POST"
                                        class="form-eliminar"
                                        data-nombre="la venta N.º {{ $venta->id }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash"></i>
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
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const carrito = [];
        const formularioVenta = document.getElementById('formVenta');
        const selectMedicamento = document.getElementById('medicamento');
        const inputCantidad = document.getElementById('cantidad');
        const tablaDetalle = document.getElementById('tablaDetalleVenta');
        const totalVenta = document.getElementById('total');
        const botonAgregar = document.getElementById('btnAgregarMedicamento');

        botonAgregar.addEventListener('click', agregarMedicamento);

        formularioVenta.addEventListener('submit', function (evento) {
            if (carrito.length === 0) {
                evento.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Venta sin medicamentos',
                    text: 'Agrega al menos un medicamento antes de registrar la venta.'
                });
            }
        });

        function agregarMedicamento() {
            const opcion = selectMedicamento.options[selectMedicamento.selectedIndex];
            const id = opcion.value;
            const nombre = opcion.dataset.nombre;
            const precio = Number(opcion.dataset.precio);
            const stock = Number(opcion.dataset.stock);
            const cantidad = Number(inputCantidad.value);

            if (!id) {
                Swal.fire({
                    icon: 'info',
                    title: 'Selecciona un medicamento',
                    text: 'Debes seleccionar un medicamento antes de agregarlo.'
                });
                return;
            }

            if (!Number.isInteger(cantidad) || cantidad <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cantidad incorrecta',
                    text: 'Ingresa una cantidad entera mayor que cero.'
                });
                return;
            }

            const existente = carrito.find(item => item.id === id);
            const cantidadAcumulada = cantidad + (existente ? existente.cantidad : 0);

            if (cantidadAcumulada > stock) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stock insuficiente',
                    text: `Solo existen ${stock} unidades disponibles de ${nombre}.`,
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            if (existente) {
                existente.cantidad = cantidadAcumulada;
                existente.subtotal = existente.precio * existente.cantidad;
            } else {
                carrito.push({
                    id,
                    nombre,
                    precio,
                    stock,
                    cantidad,
                    subtotal: precio * cantidad
                });
            }

            selectMedicamento.value = '';
            inputCantidad.value = '';
            renderizarCarrito();
        }

        function renderizarCarrito() {
            if (carrito.length === 0) {
                tablaDetalle.innerHTML = `
                    <tr id="filaCarritoVacio">
                        <td colspan="5" class="text-center text-muted">
                            Todavía no has agregado medicamentos.
                        </td>
                    </tr>
                `;
                totalVenta.textContent = '0.00';
                return;
            }

            let total = 0;

            tablaDetalle.innerHTML = carrito.map(function (item, indice) {
                total += item.subtotal;

                return `
                    <tr>
                        <td>
                            ${escapeHtml(item.nombre)}
                            <input type="hidden" name="medicamento_id[]" value="${item.id}">
                        </td>
                        <td>
                            ${item.cantidad}
                            <input type="hidden" name="cantidad[]" value="${item.cantidad}">
                        </td>
                        <td>S/ ${item.precio.toFixed(2)}</td>
                        <td>S/ ${item.subtotal.toFixed(2)}</td>
                        <td>
                            <button
                                type="button"
                                class="btn btn-danger btn-sm btn-quitar-medicamento"
                                data-indice="${indice}">
                                <i class="bi bi-x-circle"></i>
                                Quitar
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');

            totalVenta.textContent = total.toFixed(2);

            document.querySelectorAll('.btn-quitar-medicamento').forEach(function (boton) {
                boton.addEventListener('click', function () {
                    carrito.splice(Number(boton.dataset.indice), 1);
                    renderizarCarrito();
                });
            });
        }

        new DataTable('#tablaVentas', {
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            order: [[0, 'desc']],
            columnDefs: [
                {
                    targets: 5,
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                search: 'Buscar venta:',
                lengthMenu: 'Mostrar _MENU_ ventas',
                info: 'Mostrando _START_ a _END_ de _TOTAL_ ventas',
                infoEmpty: 'No hay ventas registradas',
                infoFiltered: '(filtrado de _MAX_ registros)',
                zeroRecords: 'No se encontraron ventas',
                emptyTable: 'No hay ventas disponibles',
                paginate: {
                    first: 'Primero',
                    last: 'Último',
                    next: 'Siguiente',
                    previous: 'Anterior'
                }
            }
        });
    });
</script>
@endsection
