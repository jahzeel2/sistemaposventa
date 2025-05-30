<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleDevolucionVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_devolucion_ventas', function (Blueprint $table) {
            $table->id('iddetalledevolucion');
            $table->foreignId('devolucion_id')->references('iddevolucion')->on('devolucion_ventas')->onDelete('cascade');
            $table->foreignId('articulo_id')->references('idarticulo')->on('productos')->onDelete('cascade');
            $table->string('nombre',500);
            $table->decimal('cantidad',11,3);
            $table->decimal('pventa',11,2);
            $table->decimal('descuento',11,2);
            $table->decimal('subtotal',11,2);
            $table->string('motivo',500);
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
        Schema::dropIfExists('detalle_devolucion_ventas');
    }
}
