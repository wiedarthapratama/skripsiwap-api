<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kost', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pemilik');
            $table->string('judul');
            $table->text('deskripsi');
            $table->integer('harga');
            $table->string('status');
            $table->string('jenis');
            $table->integer('jumlah');
            $table->string('listrik');
            $table->integer('id_provinsi');
            $table->integer('id_kabupaten');
            $table->integer('id_kecamatan');
            $table->string('alamat');
            $table->string('lat');
            $table->string('long');
            $table->timestamps();

            // $table->foreign('id_provinsi')->references('id')->on('provinsi');
            // $table->foreign('id_kabupaten')->references('id')->on('kabupaten');
            // $table->foreign('id_kecamatan')->references('id')->on('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kost');
    }
}
