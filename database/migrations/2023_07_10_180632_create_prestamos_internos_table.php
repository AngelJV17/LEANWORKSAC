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
        Schema::create('prestamos_internos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->integer('proyecto_prestador');
            $table->integer('proyecto_acreedor');
            $table->unsignedBigInteger('autorizado_por');
            $table->foreign('autorizado_por')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->decimal('monto', 11, 2);
            $table->string('descripcion');
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
        Schema::dropIfExists('prestamos_internos');
    }
};
