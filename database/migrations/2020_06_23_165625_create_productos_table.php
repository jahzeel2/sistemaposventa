<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('idarticulo');
            $table->foreignId('categoria_id')->references('idcategoria')->on('categorias')->onDelete('cascade');
            $table->string('codigo',50);
            $table->string('nombre',200);
            $table->double('stock',11,3);
            $table->decimal('pcompra', 11,2);
            $table->decimal('pventa', 11,2);
            $table->string('descripcion',500);
            $table->string('imagen',200);
            $table->string('estado',20);
            $table->decimal('descuento',11,2);
            $table->decimal('iva',11,2);
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
        Schema::dropIfExists('productos');
    }
}
