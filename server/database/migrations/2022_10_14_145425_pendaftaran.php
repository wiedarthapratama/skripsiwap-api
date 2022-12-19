<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pendaftaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_pemilik');
            $table->integer('id_kost');
            $table->integer('id_kost_stok');
            $table->date('tanggal_sewa');
            $table->string('foto_ktp');
            $table->string('foto_pribadi');
            $table->string('foto_kk');
            $table->string('durasi_sewa');
            $table->date('tanggal_mulai');
            $table->integer('jumlah_bayar');
            $table->timestamps();

            // $table->integer('id_user')->references('id')->on('users');
            // $table->integer('id_pemilik')->references('id')->on('pemilik');
            // $table->integer('id_kost')->references('id')->on('kost');
            // $table->integer('id_kost_stok')->references('id')->on('kost_stok');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftaran');
    }
}
