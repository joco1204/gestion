<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcionesPreguntaValoracionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opciones_pregunta_valoracion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->foreignId('pregunta_id')->constrained('preguntas_categoria_valoracion');
            $table->double('porcentaje', 8, 2);
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
        Schema::dropIfExists('opciones_pregunta_valoracion');
    }
}
