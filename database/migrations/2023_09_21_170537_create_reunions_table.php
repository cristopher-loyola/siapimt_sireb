<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReunionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reunions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_persona');
            $table->string('encargado');
            $table->string('tipo_reunion');
            $table->string('D_vinculacion');
            $table->text('descripcion_R');
            $table->string('lugar_reunion');
            $table->string('fecha_reunion');
            $table->string('participantes')->nullable();
            $table->string('area')->nullable();
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
        Schema::dropIfExists('reunions');
    }
}
