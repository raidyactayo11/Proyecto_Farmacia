<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Medicamento;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class VentaController extends Controller
{
    public function index()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $medicamentos = Medicamento::orderBy('nombre')->get();

        $ventas = Venta::with([
            'cliente',
            'detalles.medicamento',
        ])
            ->orderByDesc('id')
            ->get();

        return view('ventas.index', compact(
            'clientes',
            'medicamentos',
            'ventas'
        ));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'cliente_id' => 'required|integer|exists:clientes,id',
            'medicamento_id' => 'required|array|min:1',
            'medicamento_id.*' => 'required|integer|exists:medicamentos,id',
            'cantidad' => 'required|array|min:1',
            'cantidad.*' => 'required|integer|min:1',
        ], [
            'cliente_id.required' => 'Seleccione un cliente.',
            'medicamento_id.required' => 'Seleccione al menos un medicamento.',
            'cantidad.required' => 'Ingrese las cantidades.',
            'cantidad.*.min' => 'Las cantidades deben ser mayores que cero.',
        ]);

        if (count($datos['medicamento_id']) !== count($datos['cantidad'])) {
            throw ValidationException::withMessages([
                'cantidad' => 'La información de los medicamentos y sus cantidades está incompleta.',
            ]);
        }

        try {
            DB::transaction(function () use ($datos) {
                $total = 0;

                $venta = Venta::create([
                    'cliente_id' => $datos['cliente_id'],
                    'fecha' => now()->toDateString(),
                    'total' => 0,
                ]);

                foreach ($datos['medicamento_id'] as $index => $medicamentoId) {
                    $medicamento = Medicamento::whereKey($medicamentoId)
                        ->lockForUpdate()
                        ->firstOrFail();

                    $cantidad = $datos['cantidad'][$index];

                    if ($cantidad > $medicamento->stock) {
                        throw ValidationException::withMessages([
                            'stock' => "Stock insuficiente para {$medicamento->nombre}. Disponible: {$medicamento->stock}.",
                        ]);
                    }

                    $subtotal = $medicamento->precio * $cantidad;
                    $total += $subtotal;

                    DetalleVenta::create([
                        'venta_id' => $venta->id,
                        'medicamento_id' => $medicamento->id,
                        'cantidad' => $cantidad,
                        'precio' => $medicamento->precio,
                        'subtotal' => $subtotal,
                    ]);

                    $medicamento->decrement('stock', $cantidad);
                }

                $venta->update([
                    'total' => $total,
                ]);
            });
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('ventas.index')
                ->withErrors([
                    'error' => 'No se pudo registrar la venta. Inténtalo nuevamente.',
                ])
                ->withInput();
        }

        return redirect()
            ->route('ventas.index')
            ->with('success', 'Venta registrada correctamente.');
    }

    public function destroy(Venta $venta)
    {
        DB::transaction(function () use ($venta) {
            $venta->load('detalles');

            foreach ($venta->detalles as $detalle) {
                $medicamento = Medicamento::whereKey($detalle->medicamento_id)
                    ->lockForUpdate()
                    ->first();

                if ($medicamento) {
                    $medicamento->increment('stock', $detalle->cantidad);
                }
            }

            $venta->delete();
        });

        return redirect()
            ->route('ventas.index')
            ->with('success', 'Venta eliminada y stock restaurado correctamente.');
    }
}
