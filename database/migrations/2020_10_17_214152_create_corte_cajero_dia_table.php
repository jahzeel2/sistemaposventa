<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorteCajeroDiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corte_cajero_dia', function (Blueprint $table) {
            $table->id("idcortecaja");
            $table->foreignId('apertura_id')->references('idapertura')->on('aperturacajas')->onDelete('cascade');
            $table->decimal("total_acomulado",11,2);
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
        Schema::dropIfExists('corte_cajero_dia');
    }
}
