<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ingresos', function (Blueprint $table) {
            $table->id('iddetalle_ingreso');
            $table->foreignId('ingreso_id')->references('idingreso')->on('ingresos')->onDelete('cascade');
            $table->foreignId('articulo_id')->references('idarticulo')->on('productos')->onDelete('cascade');
            $table->decimal('cantidad', 11,3);
            $table->decimal('precio_compra', 11,2);
            $table->decimal('precio_venta', 11,2);
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_ingresos');
    }
}
