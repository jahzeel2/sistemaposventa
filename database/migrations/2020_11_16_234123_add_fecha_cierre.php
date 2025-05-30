<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaCierre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aperturacajas', function(Blueprint $table){
            $table->dateTime('fecha_hora_cierre', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('aperturacajas', function(Blueprint $table){
            $table->dropColumn('fecha_hora_cierre');
        });
    }
}
