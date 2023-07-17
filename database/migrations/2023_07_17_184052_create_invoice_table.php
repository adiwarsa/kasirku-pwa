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
        Schema::create('invoice', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('id_user');
            $table->string('invoice');
            $table->string('qty');
            $table->string('sub_total');
            $table->string('pembayaran')->nullable();
            $table->string('pembayaran_transfer')->nullable();
            $table->string('sisa')->nullable();
            $table->string('kembalian')->nullable();
            $table->string('status')->nullable();
            $table->string('jatuh_tempo')->nullable();
            $table->string('keterangan_hutang')->nullable();
            $table->string('nama_pemilik_bank')->nullable();
            $table->string('jenis_bank')->nullable();
            $table->string('bank_tujuan')->nullable();
            $table->dateTime('tanggal')->nullable();
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
        Schema::dropIfExists('invoice');
    }
};
