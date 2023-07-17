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
        Schema::create('laporan', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('id_invoice');
            $table->string('kode_produk');
            $table->string('nama_produk');
            $table->string('keuntungan_per_item');
            $table->string('total_keuntungan');
            $table->string('harga_jual');
            $table->string('qty');
            $table->string('sub_total');
            $table->dateTime('tanggal');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan');
    }
};
