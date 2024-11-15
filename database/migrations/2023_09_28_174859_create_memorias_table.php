<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memorias', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_memoria');
            $table->string('titulo');
            $table->string('encargado');
            $table->string('nombre_seminario');
            $table->string('organizador');
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
        Schema::dropIfExists('memorias');
    }
}
