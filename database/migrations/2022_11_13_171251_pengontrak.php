<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pengontrak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengontrak', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kost_jenis');
            $table->integer('id_user');
            $table->date('tanggal_masuk');
            $table->string('status');
            $table->string('nomor_kost');
            $table->integer('id_pendaftaran');
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
        Schema::dropIfExists('pengontrak');
    }
}
