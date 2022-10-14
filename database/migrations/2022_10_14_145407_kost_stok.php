<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class KostStok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kost_stok', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kost');
            $table->integer('id_user');
            $table->string('tersedia');
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
        Schema::dropIfExists('kost_stok');
    }
}
