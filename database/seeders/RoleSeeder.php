<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::updateOrCreate(
            ['nombre' => 'Administrador'],
            ['descripcion' => 'Acceso completo al sistema']
        );

        Role::updateOrCreate(
            ['nombre' => 'Cajero'],
            ['descripcion' => 'Acceso a ventas y consultas básicas']
        );
    }
}