<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('venta_id');

            $table->unsignedBigInteger('medicamento_id');

            $table->integer('cantidad');

            $table->decimal('precio', 10, 2);

            $table->decimal('subtotal', 10, 2);

            $table->timestamps();

            $table->foreign('venta_id')
                  ->references('id')
                  ->on('ventas')
                  ->onDelete('cascade');

            $table->foreign('medicamento_id')
                  ->references('id')
                  ->on('medicamentos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
    }
}