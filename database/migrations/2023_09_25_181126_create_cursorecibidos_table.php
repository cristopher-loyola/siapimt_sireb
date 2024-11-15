<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursorecibidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

public function up()
{
    Schema::create('cursorecibidos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_curso');
        $table->string('fecha_inicio');
        $table->string('encargado');
        $table->string('fecha_fin');
        $table->string('duracion_curso');
        $table->string('I_organizadora');
        $table->string('lugar');
        $table->string('nombre_persona');
        $table->string('area')->nullable();
        $table->string('participantes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cursorecibidos');
    }
}
