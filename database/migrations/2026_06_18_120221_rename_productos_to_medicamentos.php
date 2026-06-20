<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('productos', 'medicamentos');
    }

    public function down(): void
    {
        Schema::rename('medicamentos', 'productos');
    }
};