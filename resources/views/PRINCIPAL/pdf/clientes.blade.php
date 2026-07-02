<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Clientes</title>

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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #0d6efd;
            color: white;
            padding: 8px;
            text-align: left;
        }

        td {
            border: 1px solid #ddd;
            padding: 7px;
        }

        tr:nth-child(even) {
            background-color: #f5f5f5;
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
    <h1>Reporte de Clientes</h1>

    <p class="subtitulo">
        Farmacia San Juan - Generado el {{ now()->format('d/m/Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>DNI</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Ventas</th>
            </tr>
        </thead>

        <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->dni }}</td>
                    <td>{{ $cliente->telefono ?? '-' }}</td>
                    <td>{{ $cliente->direccion ?? '-' }}</td>
                    <td>{{ $cliente->ventas_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total de clientes: {{ $clientes->count() }}
    </div>
</body>
</html>
