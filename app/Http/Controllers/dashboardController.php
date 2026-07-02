<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Medicamento;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;

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

        $ventasPorDia = Venta::selectRaw('fecha, SUM(total) as total')
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->take(7)
            ->get();

        $stockMedicamentos = Medicamento::orderBy('stock')
            ->take(5)
            ->get(['nombre', 'stock']);

        $ventasPorCliente = Venta::select('cliente_id', DB::raw('SUM(total) as total'))
            ->with('cliente')
            ->groupBy('cliente_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('PRINCIPAL.dashboard', compact(
            'totalCategorias',
            'totalMedicamentos',
            'totalClientes',
            'totalVentas',
            'montoTotalVentas',
            'medicamentosBajoStock',
            'ventasRecientes',
            'ventasPorDia',
            'stockMedicamentos',
            'ventasPorCliente'
        ));
    }

    public function cajero()
    {
        $totalVentas = Venta::count();
        $montoTotalVentas = Venta::sum('total');
        $medicamentosBajoStock = Medicamento::where('stock', '<=', 5)->count();

        $ventasRecientes = Venta::with('cliente')
            ->latest()
            ->take(5)
            ->get();

        return view('PRINCIPAL.dashboard_cajero', compact(
            'totalVentas',
            'montoTotalVentas',
            'medicamentosBajoStock',
            'ventasRecientes'
        ));
    }
}
