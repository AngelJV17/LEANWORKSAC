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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->string('codigo')->unique();
            $table->string('dni_ce')->unique();
            $table->string('foto')->nullable();
            $table->string('nombres');
            $table->string('apellidos');
            $table->timestamp('fecha_nacimiento')->nullable();
            $table->string('sexo');
            $table->string('celular');
            $table->string('direccion')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('rol_id')->unsigned();
            $table->foreign('rol_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('usuarios');
    }
};
