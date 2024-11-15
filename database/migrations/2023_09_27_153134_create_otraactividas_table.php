<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtraactividasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otraactividas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_actividad');
            $table->string('encargado');
            $table->string('fecha');
            $table->string('tipo_actividad');
            $table->text('descripcion');
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
        Schema::dropIfExists('otraactividas');
    }
}
