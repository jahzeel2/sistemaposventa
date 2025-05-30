<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCorteCajeroDia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('corte_cajero_dia', function(Blueprint $table){
            $table->string('numfolio',100)
            ->after('total_acomulado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('corte_cajero_dia', function(Blueprint $table){
            $table->dropColumn('numfolio');
        });
    }
}
