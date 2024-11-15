<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibrosUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libros_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('libros_id');
            $table->integer('usuario_id');
            $table->timestamps();

            $table->foreign('libros_id')->references('id')->on('libros');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('libros_usuarios');
    }
}
