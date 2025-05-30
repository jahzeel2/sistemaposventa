<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucion_ventas', function (Blueprint $table) {
            $table->id('iddevolucion');
            $table->foreignId('venta_id')->references('idventa')->on('ventas')->onDelete('cascade');
            $table->string('observacion',1000);
            $table->dateTime('fecha');
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
        Schema::dropIfExists('devolucion_ventas');
    }
}
