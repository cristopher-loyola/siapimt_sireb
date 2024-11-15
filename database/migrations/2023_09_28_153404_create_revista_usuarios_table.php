<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevistaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revista_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('revista_id');
            $table->integer('usuario_id');
            $table->timestamps();

            $table->foreign('revista_id')->references('id')->on('revistas');
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
        Schema::dropIfExists('revista_usuarios');
    }
}
