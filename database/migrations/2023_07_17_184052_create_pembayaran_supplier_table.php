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
        Schema::create('pembayaran_supplier', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('id_supplier');
            $table->string('nama_produk_supplier');
            $table->string('total_penjualan');
            $table->string('total_pembayaran');
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
        Schema::dropIfExists('pembayaran_supplier');
    }
};
