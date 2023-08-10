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
            $table->boolean('is_caja_chica')->after('id_inversiones')->nullable();
            $table->unsignedBigInteger('id_caja_chica')->after('is_caja_chica')->nullable();
            $table->foreign('id_caja_chica')->references('id')->on('cajas_chica')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('is_viatico')->after('id_caja_chica')->nullable();
            $table->unsignedBigInteger('id_viaticos')->after('is_viatico')->nullable();
            $table->foreign('id_viaticos')->references('id')->on('viaticos')->onUpdate('cascade')->onDelete('cascade');
            
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
            $table->dropColumn('is_caja_chica');
            $table->dropColumn('id_caja_chica');
            $table->dropColumn('is_viatico');
            $table->dropColumn('id_viaticos');
        });
    }
};
