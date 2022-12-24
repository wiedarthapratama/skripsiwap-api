<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pengerjaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengerjaan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pengaduan');
            $table->integer('id_pekerja');
            $table->string('status');
            $table->string('durasi_pengerjaan');
            $table->timestamps();

            // $table->foreign('id_pengaduan')->references('id')->on('pengaduan');
            // $table->foreign('id_pekerja')->references('id')->on('pekerja');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengerjaan');
    }
}
