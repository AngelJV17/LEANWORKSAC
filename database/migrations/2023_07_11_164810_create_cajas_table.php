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
        Schema::create('cajas', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');

            $table->unsignedBigInteger('proyecto_id')->unsigned();
            $table->foreign('proyecto_id')->references('id')->on('proyectos')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('operacion');
            $table->integer('tipo');
            $table->integer('subtipo');

            $table->unsignedBigInteger('autorizado_por')->unsigned();
            $table->foreign('autorizado_por')->references('id')->on('usuarios')->onUpdate('cascade')->onDelete('cascade');
            
            $table->string('realizado_a_favor');
            $table->double('monto', 8, 2);
            $table->string('descripcion');
            $table->boolean('is_prestamo')->nullable();
            $table->integer('id_prestamos_internos')->nullable();
            $table->unsignedBigInteger('id_control_caja')->unsigned();
            $table->foreign('id_control_caja')->references('id')->on('control_caja')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('cajas');
    }
};
