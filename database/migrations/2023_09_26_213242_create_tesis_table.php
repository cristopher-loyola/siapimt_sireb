<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTesisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tesis', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_tesis');
            $table->string('participacion');
            $table->string('nombre_alumno');
            $table->string('encargado');
            $table->string('nombre_especialidad');
            $table->string('facultad');
            $table->string('grado');
            $table->string('institucion');
            $table->string('fecha_inicio');
            $table->string('fechaT_titulacion');
            $table->string('fase_tesis');
            $table->string('area')->nullable();
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
        Schema::dropIfExists('tesis');
    }
}
