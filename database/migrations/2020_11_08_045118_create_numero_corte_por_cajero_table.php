<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNumeroCortePorCajeroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numero_corte_por_cajero', function (Blueprint $table) {
            $table->id("idnumerocorte");
            $table->foreignId('cortecaja_id')->references('idcortecaja')->on('corte_cajero_dia')->onDelete('cascade');
            $table->decimal('cantidad',11,2);
            $table->date('fecha');
            $table->time('hora', 0);
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
        Schema::dropIfExists('numero_corte_por_cajero');
    }
}
