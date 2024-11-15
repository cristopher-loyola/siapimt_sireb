<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revistas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_revista');
            $table->string('titulo');
            $table->string('encargado');
            $table->string('tipo_articulo');
            $table->string('nombre_revista');
            $table->string('numero_revista');
            $table->string('editorial');
            $table->string('ciudad_pais');
            $table->string('fecha');
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
        Schema::dropIfExists('revistas');
    }
}
