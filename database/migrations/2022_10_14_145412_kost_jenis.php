<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KostJenis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kost_jenis', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_petak');
            $table->boolean('is_perabot');
            $table->boolean('is_rumah');
            $table->boolean('is_kamar_mandi_dalam');
            $table->boolean('is_listrik');
            $table->timestamps();

            // $table->foreign('id_kost')->references('id')->on('kost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kost_jenis');
    }
}
