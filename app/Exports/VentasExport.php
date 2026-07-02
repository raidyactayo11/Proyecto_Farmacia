<?php

namespace App\Exports;

use App\Models\Venta;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VentasExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Venta::with('cliente')
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cliente',
            'Fecha',
            'Total',
        ];
    }

    public function map($venta): array
    {
        return [
            $venta->id,
            $venta->cliente->nombre ?? 'Cliente eliminado',
            optional($venta->created_at)->format('d/m/Y H:i'),
            $venta->total,
        ];
    }
}
