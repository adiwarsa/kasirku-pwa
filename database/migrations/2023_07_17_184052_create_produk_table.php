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
        Schema::create('produk', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('id_supplier')->nullable();
            $table->string('kode');
            $table->string('nama_produk');
            $table->string('harga_beli');
            $table->string('harga_jual');
            $table->string('foto')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('expired')->nullable();
            $table->string('produk_supplier_terjual')->nullable();
            $table->string('stok');
            $table->string('status');
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
        Schema::dropIfExists('produk');
    }
};
