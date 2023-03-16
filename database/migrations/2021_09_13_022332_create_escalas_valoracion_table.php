<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscalasValoracionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escalas_valoracion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('color');
            $table->integer('porcentaje');
            $table->foreignId('cantidad_casillas_id')->constrained('parametros_detalles');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escalas_valoracion');
    }
}
