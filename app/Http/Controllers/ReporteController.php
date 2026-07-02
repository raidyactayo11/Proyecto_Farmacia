<?php

namespace App\Http\Controllers;

use App\Exports\ClientesExport;
use App\Exports\MedicamentosExport;
use App\Exports\VentasExport;
use App\Models\Cliente;
use App\Models\Medicamento;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

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

    public function medicamentosPdf()
    {
        $medicamentos = Medicamento::with('categoria')
            ->orderBy('nombre')
            ->get();

        $pdf = Pdf::loadView('PRINCIPAL.pdf.medicamentos', compact('medicamentos'));

        return $pdf->download('reporte_medicamentos.pdf');
    }

    public function ventasPdf()
    {
        $ventas = Venta::with(['cliente', 'detalles.medicamento'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('PRINCIPAL.pdf.ventas', compact('ventas'));

        return $pdf->download('reporte_ventas.pdf');
    }

    public function clientesPdf()
    {
        $clientes = Cliente::withCount('ventas')
            ->orderBy('nombre')
            ->get();

        $pdf = Pdf::loadView('PRINCIPAL.pdf.clientes', compact('clientes'));

        return $pdf->download('reporte_clientes.pdf');
    }

    public function medicamentosExcel()
    {
        return Excel::download(new MedicamentosExport(), 'reporte_medicamentos.xlsx');
    }

    public function ventasExcel()
    {
        return Excel::download(new VentasExport(), 'reporte_ventas.xlsx');
    }

    public function clientesExcel()
    {
        return Excel::download(new ClientesExport(), 'reporte_clientes.xlsx');
    }
}
