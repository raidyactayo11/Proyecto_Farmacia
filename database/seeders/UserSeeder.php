<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $rolAdministrador = Role::where('nombre', 'Administrador')->first();
        $rolCajero = Role::where('nombre', 'Cajero')->first();

        User::updateOrCreate(
            ['email' => 'admin@farmacia.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'role_id' => $rolAdministrador->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'cajero@farmacia.com'],
            [
                'name' => 'Cajero',
                'password' => Hash::make('password'),
                'role_id' => $rolCajero->id,
            ]
        );
    }
}
