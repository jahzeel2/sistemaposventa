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
            $table->id('iddetalle_venta');
            $table->foreignId('venta_id')->references('idventa')->on('ventas')->onDelete('cascade');
            $table->foreignId('articulo_id')->references('idarticulo')->on('productos')->onDelete('cascade');
            $table->foreignId('apertura_id')->references('idapertura')->on('aperturacajas')->onDelete('cascade');
            $table->decimal('cantidad',11,3);
            $table->decimal('precio_venta',11,2);
            $table->decimal('descuento',11,2);
            $table->decimal('subtotal',11,2);
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
