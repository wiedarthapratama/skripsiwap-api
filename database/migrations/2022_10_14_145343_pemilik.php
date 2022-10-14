<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pemilik extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemilik', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_provinsi');
            $table->integer('id_kabupaten');
            $table->integer('id_kecamatan');
            $table->string('alamat');
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
        Schema::dropIfExists('pemilik');
    }
}
