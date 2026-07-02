<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitulo {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
        }

        .venta {
            margin-bottom: 25px;
            border: 1px solid #ddd;
            padding: 10px;
        }

        .venta-header {
            background-color: #0d6efd;
            color: white;
            padding: 8px;
            margin: -10px -10px 10px -10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th {
            background-color: #e9ecef;
            padding: 7px;
            text-align: left;
        }

        td {
            border: 1px solid #ddd;
            padding: 7px;
        }

        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 8px;
        }

        .footer {
            margin-top: 25px;
            text-align: right;
            font-size: 11px;
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Reporte de Ventas</h1>

    <p class="subtitulo">
        Farmacia San Juan - Generado el {{ now()->format('d/m/Y H:i') }}
    </p>

    @foreach($ventas as $venta)
        <div class="venta">
            <div class="venta-header">
                Venta #{{ $venta->id }} - {{ $venta->created_at->format('d/m/Y H:i') }}
            </div>

            <p>
                <strong>Cliente:</strong>
                {{ $venta->cliente->nombre ?? 'Cliente eliminado' }}
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Medicamento</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($venta->detalles as $detalle)
                        <tr>
                            <td>{{ $detalle->medicamento->nombre ?? 'Medicamento eliminado' }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>S/ {{ number_format($detalle->precio, 2) }}</td>
                            <td>S/ {{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <p class="total">
                Total: S/ {{ number_format($venta->total, 2) }}
            </p>
        </div>
    @endforeach

    <div class="footer">
        Total de ventas: {{ $ventas->count() }}
    </div>
</body>
</html>
