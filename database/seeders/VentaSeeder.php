<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Medicamento;
use App\Models\Venta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VentaSeeder extends Seeder
{
    public function run()
    {
        DB::transaction(function () {
            $cliente = Cliente::where('dni', '12345678')->first();

            $paracetamol = Medicamento::where('nombre', 'Paracetamol 500mg')->first();
            $ibuprofeno = Medicamento::where('nombre', 'Ibuprofeno 400mg')->first();

            $items = [
                [
                    'medicamento' => $paracetamol,
                    'cantidad' => 2,
                ],
                [
                    'medicamento' => $ibuprofeno,
                    'cantidad' => 1,
                ],
            ];

            $total = 0;

            foreach ($items as $item) {
                $total += $item['medicamento']->precio * $item['cantidad'];
            }

            $venta = Venta::updateOrCreate(
                [
                    'cliente_id' => $cliente->id,
                    'fecha' => now()->toDateString(),
                ],
                [
                    'total' => $total,
                ]
            );

            $venta->detalles()->delete();

            foreach ($items as $item) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'medicamento_id' => $item['medicamento']->id,
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['medicamento']->precio,
                    'subtotal' => $item['medicamento']->precio * $item['cantidad'],
                ]);
            }
        });
    }
}