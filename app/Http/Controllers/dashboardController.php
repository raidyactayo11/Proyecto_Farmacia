<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Medicamento;
use App\Models\Venta;

class dashboardController extends Controller
{
    public function index()
    {
        $totalCategorias = Categoria::count();
        $totalMedicamentos = Medicamento::count();
        $totalClientes = Cliente::count();
        $totalVentas = Venta::count();

        $montoTotalVentas = Venta::sum('total');

        $medicamentosBajoStock = Medicamento::where('stock', '<=', 5)->count();

        $ventasRecientes = Venta::with('cliente')
            ->latest()
            ->take(5)
            ->get();

        return view('PRINCIPAL.dashboard', compact(
            'totalCategorias',
            'totalMedicamentos',
            'totalClientes',
            'totalVentas',
            'montoTotalVentas',
            'medicamentosBajoStock',
            'ventasRecientes'
        ));
    }
}