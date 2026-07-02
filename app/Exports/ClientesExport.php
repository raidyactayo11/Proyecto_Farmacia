<?php

namespace App\Exports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Cliente::withCount('ventas')
            ->orderBy('nombre')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'DNI',
            'Teléfono',
            'Dirección',
            'Cantidad de ventas',
        ];
    }

    public function map($cliente): array
    {
        return [
            $cliente->nombre,
            $cliente->dni,
            $cliente->telefono,
            $cliente->direccion,
            $cliente->ventas_count,
        ];
    }
}
