<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miconfigs', function (Blueprint $table) {
            $table->string('anio')->primary();            
            $table->string('PI1')->nullable();
            $table->string('CPT1-2')->nullable();
            $table->string('MIPC3')->nullable();
            $table->decimal('IPC4', 3, 2)->nullable();
            $table->string('PE5')->nullable();
            $table->string('CPT2-6')->nullable();
            $table->string('MIPEC7')->nullable();
            $table->string('PIIE8')->nullable();
            $table->string('EL9')->nullable();
            $table->decimal('ELC10', 3, 2)->nullable();
            $table->string('APRMN11')->nullable();
            $table->decimal('IAPRMN12', 3, 2)->nullable();
            $table->string('APRMI13')->nullable();
            $table->decimal('IAPRMI14', 3, 2)->nullable();
            $table->string('AB15')->nullable();
            $table->decimal('IAB16', 3, 2)->nullable();
            $table->string('CSC17')->nullable();
            $table->decimal('ICSC18', 3, 2)->nullable();
            $table->string('PT19')->nullable();
            $table->decimal('IPT20', 3, 2)->nullable();
            $table->string('ACA21')->nullable();
            $table->decimal('IACA22', 3, 2)->nullable();
            $table->string('IOGDML23')->nullable();
            $table->decimal('IIOGDML24', 3, 2)->nullable();
            $table->string('CI25')->nullable();
            $table->decimal('ICI26', 3, 2)->nullable();
            $table->string('CIR27')->nullable();
            $table->decimal('ICIR28', 3, 2)->nullable();
            $table->string('TITD29')->nullable();
            $table->decimal('ITITD30', 3, 2)->nullable();
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
        Schema::dropIfExists('miconfigs');
    }
}
