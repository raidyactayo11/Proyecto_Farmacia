<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Medicamento;
use App\Models\Venta;

class ReporteController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('cliente')
            ->latest()
            ->get();

        $medicamentosBajoStock = Medicamento::with('categoria')
            ->where('stock', '<=', 5)
            ->orderBy('stock')
            ->get();

        $clientesConVentas = Cliente::withCount('ventas')
            ->orderByDesc('ventas_count')
            ->get();

        return view('PRINCIPAL.reportes', compact(
            'ventas',
            'medicamentosBajoStock',
            'clientesConVentas'
        ));
    }
}