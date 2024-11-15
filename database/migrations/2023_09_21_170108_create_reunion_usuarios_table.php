<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReunionUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reunion_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reunion_id');
            $table->integer('usuario_id');
            $table->timestamps();

            $table->foreign('reunion_id')->references('id')->on('reunions');
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
        Schema::dropIfExists('reunion_usuarios');
    }
}
