<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Medicamentos</title>

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

        .stock-bajo {
            color: #dc3545;
            font-weight: bold;
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
    <h1>Reporte de Medicamentos</h1>

    <p class="subtitulo">
        Farmacia San Juan - Generado el {{ now()->format('d/m/Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Medicamento</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Descripción</th>
            </tr>
        </thead>

        <tbody>
            @foreach($medicamentos as $medicamento)
                <tr>
                    <td>{{ $medicamento->nombre }}</td>
                    <td>{{ $medicamento->categoria->nombre ?? 'Sin categoría' }}</td>
                    <td>S/ {{ number_format($medicamento->precio, 2) }}</td>
                    <td class="{{ $medicamento->stock <= 5 ? 'stock-bajo' : '' }}">
                        {{ $medicamento->stock }}
                    </td>
                    <td>{{ $medicamento->descripcion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total de medicamentos: {{ $medicamentos->count() }}
    </div>
</body>
</html>