<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comites', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_persona');
            $table->string('nombre_comite');
            $table->string('encargado');
            $table->string('cargo_comite');
            $table->string('dependencia_V');
            $table->text('A_desarrolladas');
            $table->string('fechas');
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
        Schema::dropIfExists('comites');
    }
}
