<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoriaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memoria_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('memoria_id');
            $table->integer('usuario_id');
            $table->timestamps();

            $table->foreign('memoria_id')->references('id')->on('memorias');
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
        Schema::dropIfExists('memoria_usuarios');
    }
}
