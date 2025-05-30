<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAperturacajasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aperturacajas', function (Blueprint $table) {
            $table->id("idapertura");
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal("cantidad_inicial",11,2);
            $table->decimal("cantidad_final",11,2);
            $table->string("estatus",100);
            $table->dateTime('fecha_hora', 0);
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
        Schema::dropIfExists('aperturacajas');
    }
}
