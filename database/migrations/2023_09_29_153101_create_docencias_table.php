<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docencias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_curso');
            $table->string('fecha_inicio');
            $table->string('fecha_fin');
            $table->string('duracion_curso');
            $table->string('institucion_impartio');
            $table->string('lugar');
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
        Schema::dropIfExists('docencias');
    }
}
