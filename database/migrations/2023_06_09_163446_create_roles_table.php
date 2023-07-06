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
        Schema::create('roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('nombre')->unique();
            $table->string('descripcion');
            $table->unsignedInteger('gestion_usuario');
            $table->unsignedInteger('gestion_caja');
            $table->unsignedInteger('gestion_roles');
            $table->unsignedInteger('gestion_proyectos');
            $table->unsignedInteger('gestion_parametros_globales');
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
        Schema::dropIfExists('roles');
    }
};
