<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KostTipe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kost_tipe', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kost');
            // $table->integer('id_kost_jenis');
            $table->integer('jumlah_kontrakan');
            $table->integer('harga_per_bulan');
            $table->integer('jumlah_ruang');
            $table->boolean('is_perabot');
            $table->boolean('is_rumah');
            $table->boolean('is_kamar_mandi_dalam');
            $table->boolean('is_listrik');
            $table->string('luas');
            $table->timestamps();

            // $table->foreign('id_kost')->references('id')->on('kost');
            // $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kost_tipe');
    }
}
