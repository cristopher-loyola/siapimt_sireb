<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursorecibidoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cursorecibido_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cursorecibido_id');
            $table->integer('usuario_id');
            $table->timestamps();

            $table->foreign('cursorecibido_id')->references('id')->on('cursorecibidos');
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
        Schema::dropIfExists('cursorecibido_usuarios');
    }
}
