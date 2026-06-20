<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Medicamento;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();

        $medicamentos = Medicamento::all();

        $ventas = Venta::with([
            'cliente',
            'detalles.medicamento'
        ])
        ->orderBy('id', 'desc')
        ->get();

        return view('ventas.index', compact(
            'clientes',
            'medicamentos',
            'ventas'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
            'medicamento_id' => 'required|array',
            'cantidad' => 'required|array'
        ], [
            'cliente_id.required' => 'Seleccione un cliente.',
            'medicamento_id.required' => 'Seleccione al menos un medicamento.',
            'cantidad.required' => 'Ingrese cantidades.'
        ]);

        DB::beginTransaction();

        try {

            $total = 0;

            // Crear venta vacía primero
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'fecha' => now(),
                'total' => 0
            ]);

            foreach ($request->medicamento_id as $index => $med_id) {

                $medicamento = Medicamento::findOrFail($med_id);

                $cantidad = $request->cantidad[$index];

                // VALIDAR STOCK
                if ($cantidad > $medicamento->stock) {
                    return redirect()
                        ->route('ventas.index')
                        ->withErrors([
                            'stock' => "Stock insuficiente para {$medicamento->nombre}"
                        ])
                        ->withInput();
                }

                $subtotal = $medicamento->precio * $cantidad;

                $total += $subtotal;

                // DETALLE
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'medicamento_id' => $medicamento->id,
                    'cantidad' => $cantidad,
                    'precio' => $medicamento->precio,
                    'subtotal' => $subtotal
                ]);

                // DESCONTAR STOCK
                $medicamento->stock -= $cantidad;
                $medicamento->save();
            }

            // ACTUALIZAR TOTAL FINAL
            $venta->update([
                'total' => $total
            ]);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('ventas.index')
                ->withErrors([
                    'error' => 'Error al registrar la venta: ' . $e->getMessage()
                ]);
        }

        return redirect()
            ->route('ventas.index')
            ->with('success', 'Venta registrada correctamente.');
    }

    public function destroy(Venta $venta)
    {
        $venta->delete();

        return redirect()
            ->route('ventas.index')
            ->with('success', 'Venta eliminada correctamente.');
    }
}