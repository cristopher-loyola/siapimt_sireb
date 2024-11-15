<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePonenciasconferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ponenciasconferencias', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_PC');
            $table->string('entidad_O');
            $table->string('encargado');
            $table->string('titulo');
            $table->string('fecha_inicio');
            $table->string('fecha_fin');
            $table->string('tipo_participacion');
            $table->string('publicacion_PC');
            $table->string('fecha_part_ponente');
            $table->string('nombre_evento');
            $table->string('lugar_evento');
            $table->string('nombre_persona');
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
        Schema::dropIfExists('ponenciasconferencias');
    }
}
