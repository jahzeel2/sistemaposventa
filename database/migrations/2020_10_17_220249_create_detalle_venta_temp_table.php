<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentaTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_venta_temp', function (Blueprint $table) {
            $table->id("iddetalletemp");
            $table->integer("id_user");
            $table->integer("idarticulo");
            $table->string("codproducto",50);
            $table->string("nombre",1000);
            $table->decimal("cantidad",11,3);
            $table->decimal("precio",11,2);
            $table->decimal("descuento",11,2);
            $table->decimal("iva",11,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_venta_temp');
    }
}
