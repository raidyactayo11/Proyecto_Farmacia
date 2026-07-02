<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $categorias = [
            [
                'nombre' => 'Analgésicos',
                'descripcion' => 'Medicamentos utilizados para aliviar el dolor.',
            ],
            [
                'nombre' => 'Antibióticos',
                'descripcion' => 'Medicamentos usados para tratar infecciones bacterianas.',
            ],
            [
                'nombre' => 'Antiinflamatorios',
                'descripcion' => 'Medicamentos que reducen inflamación y dolor.',
            ],
            [
                'nombre' => 'Vitaminas',
                'descripcion' => 'Suplementos para fortalecer el organismo.',
            ],
            [
                'nombre' => 'Antigripales',
                'descripcion' => 'Medicamentos para aliviar síntomas de gripe y resfrío.',
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::updateOrCreate(
                ['nombre' => $categoria['nombre']],
                ['descripcion' => $categoria['descripcion']]
            );
        }
    }
}