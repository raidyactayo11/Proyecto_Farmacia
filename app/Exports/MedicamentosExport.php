<?php

namespace App\Exports;

use App\Models\Medicamento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MedicamentosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Medicamento::with('categoria')
            ->orderBy('nombre')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Medicamento',
            'Categoría',
            'Precio',
            'Stock',
            'Descripción',
        ];
    }

    public function map($medicamento): array
    {
        return [
            $medicamento->nombre,
            $medicamento->categoria->nombre ?? 'Sin categoría',
            $medicamento->precio,
            $medicamento->stock,
            $medicamento->descripcion,
        ];
    }
}
