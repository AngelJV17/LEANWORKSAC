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
        Schema::table('cajas', function (Blueprint $table) {
            $table->boolean('is_inversion')->after('id_prestamos_internos')->nullable();
            $table->unsignedBigInteger('id_inversiones')->after('is_inversion')->nullable();
            $table->foreign('id_inversiones')->references('id')->on('inversiones')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cajas', function (Blueprint $table) {
            $table->dropColumn('is_inversion');
            $table->dropColumn('id_inversiones');
        });
    }
};
