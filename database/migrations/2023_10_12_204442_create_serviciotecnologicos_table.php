<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciotecnologicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('serviciotecnologicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_persona');
            $table->string('nombreservicio');
            $table->string('encargado');
            $table->string('numeroregistro');
            $table->string('nombrecliente');
            $table->string('servicio');
            $table->decimal('costo', 10, 2);
            $table->string('numerococ');
            $table->string('fechainicio');
            $table->string('fechafin');
            $table->integer('duracion');
            $table->string('participantes')->nullable();
            $table->string('area')->nullable();

            $table->string('participacion')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('porcentaje')->nullable();
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
        Schema::dropIfExists('serviciotecnologicos');
    }
}
