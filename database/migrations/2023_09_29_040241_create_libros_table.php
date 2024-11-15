<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('año');
            $table->string('encargado');
            $table->string('titulo');
            $table->string('editorial');
            $table->string('ciudad');
            $table->string('pais');
            $table->string('isbn');
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
        Schema::dropIfExists('libros');
    }
}
