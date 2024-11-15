<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComiteUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comite_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comite_id');
            $table->integer('usuario_id');
            $table->timestamps();
    
            $table->foreign('comite_id')->references('id')->on('comites');
            $table->foreign('usuario_id')->references('id')->on('usuarios');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comite_usuarios');
    }
}
