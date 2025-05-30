<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSerieCorteCajeroDia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('corte_cajero_dia', function(Blueprint $table){
            $table->string('seriefolio',100)
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
            $table->dropColumn('seriefolio');
        });
    }
}
