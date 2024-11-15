<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciotecnologicoUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serviciotecnologico_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('serviciostec_id');
            $table->integer('usuario_id');
            $table->string('participacionusuario')->nullable();
            $table->text('descripcionusuario')->nullable();
            $table->timestamps();
    
            $table->foreign('serviciostec_id')->references('id')->on('serviciotecnologicos');
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
        Schema::dropIfExists('serviciotecnologico_usuarios');
    }
}
