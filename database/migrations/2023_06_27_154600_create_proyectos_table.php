<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('codigo_proyecto')->unique();
            $table->string('nombre_proyecto')->unique();
            $table->double('monto_proyectado', 8, 2);
            
            $table->unsignedBigInteger('departamento_id')->unsigned();
            $table->foreign('departamento_id')->references('id')->on('ubigeo_peru_departamentos')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('provincia_id')->unsigned();
            $table->foreign('provincia_id')->references('id')->on('ubigeo_peru_provincias')->onUpdate('cascade')->onDelete('cascade');

            $table->unsignedBigInteger('distrito_id')->unsigned();
            $table->foreign('distrito_id')->references('id')->on('ubigeo_peru_distritos')->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('proyectos');
    }
};
