<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostgradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postgrados', function (Blueprint $table) {
            $table->id();
            $table->string('grado');
            $table->string('fecha_inicio');
            $table->string('encargado');
            $table->string('fechaT_titulacion');
            $table->string('titulo_postgrado');
            $table->string('institucion');
            $table->text('A_desarrolladas');
            $table->string('titulo_tesis');
            $table->string('estado');
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
        Schema::dropIfExists('postgrados');
    }
}
