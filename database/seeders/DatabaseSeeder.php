<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategoriaSeeder::class,
            MedicamentoSeeder::class,
            ClienteSeeder::class,
            VentaSeeder::class,
        ]);
    }
}