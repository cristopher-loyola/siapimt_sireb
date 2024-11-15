<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePonenciaconferenciaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ponenciaconferencia_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ponenciaconferencia_id');
            $table->integer('usuario_id');
            $table->timestamps();

            $table->foreign('ponenciaconferencia_id')->references('id')->on('ponenciasconferencias');
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
        Schema::dropIfExists('ponenciaconferencia_usuarios');
    }
}
