<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Medicamento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MedicamentoSeeder extends Seeder
{
    public function run()
    {
        $medicamentos = [
            [
                'categoria' => 'Analgésicos',
                'nombre' => 'Paracetamol 500mg',
                'precio' => 2.50,
                'stock' => 100,
                'descripcion' => 'Alivia dolores leves y fiebre.',
            ],
            [
                'categoria' => 'Antibióticos',
                'nombre' => 'Amoxicilina 500mg',
                'precio' => 8.90,
                'stock' => 60,
                'descripcion' => 'Antibiótico de amplio espectro.',
            ],
            [
                'categoria' => 'Antiinflamatorios',
                'nombre' => 'Ibuprofeno 400mg',
                'precio' => 3.20,
                'stock' => 80,
                'descripcion' => 'Reduce inflamación, dolor y fiebre.',
            ],
            [
                'categoria' => 'Vitaminas',
                'nombre' => 'Vitamina C 1000mg',
                'precio' => 1.80,
                'stock' => 120,
                'descripcion' => 'Suplemento para fortalecer defensas.',
            ],
            [
                'categoria' => 'Antigripales',
                'nombre' => 'Antigripal Forte',
                'precio' => 4.50,
                'stock' => 40,
                'descripcion' => 'Alivia síntomas de gripe y resfrío.',
            ],
        ];

        foreach ($medicamentos as $item) {
            $categoria = Categoria::where('nombre', $item['categoria'])->first();

            Medicamento::updateOrCreate(
                ['nombre' => $item['nombre']],
                [
                    'categoria_id' => $categoria->id,
                    'slug' => Str::slug($item['nombre']),
                    'precio' => $item['precio'],
                    'stock' => $item['stock'],
                    'descripcion' => $item['descripcion'],
                    'imagen' => null,
                ]
            );
        }
    }
}