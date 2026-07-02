<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        $clientes = [
            [
                'nombre' => 'Carlos Ramírez',
                'dni' => '12345678',
                'telefono' => '987654321',
                'direccion' => 'Av. San Martín 123',
            ],
            [
                'nombre' => 'María Torres',
                'dni' => '87654321',
                'telefono' => '912345678',
                'direccion' => 'Jr. Los Olivos 456',
            ],
            [
                'nombre' => 'Luis Mendoza',
                'dni' => '45678912',
                'telefono' => '956789123',
                'direccion' => 'Calle Lima 789',
            ],
            [
                'nombre' => 'Ana Flores',
                'dni' => '78912345',
                'telefono' => '934567891',
                'direccion' => 'Av. Perú 321',
            ],
        ];

        foreach ($clientes as $cliente) {
            Cliente::updateOrCreate(
                ['dni' => $cliente['dni']],
                $cliente
            );
        }
    }
}