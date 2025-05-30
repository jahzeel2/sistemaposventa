<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleEntradaTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_entrada_temp', function (Blueprint $table) {
            $table->id("identradatemp");
            $table->integer("id_user");
            $table->integer("idarticulo");
            $table->string("codigo",50);
            $table->string("nombre",1000);
            $table->decimal("cantidad",11,3);
            $table->decimal("pcompra",11,2);
            $table->decimal("pventa",11,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_entrada_temp');
    }
}
