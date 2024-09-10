<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->integer('user_id');
            $table->text('keterangan');
            $table->enum('metode', ['cash', 'online']);
            $table->enum('jenis', ['penuh', 'cicil']);
            $table->enum('status', ['0', '1', '2']);
            $table->timestamps();
        });

        Schema::create('kategori_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('harga');
            $table->string('interval');
            $table->timestamps();
        });

        Schema::create('list_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->integer('kategori_id');
            $table->string('harga');
            $table->timestamps();
        });

        Schema::create('list_cicil_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('bulan');
            $table->string('cicilan');
            $table->string('expired');
            $table->enum('status', ['lunas', 'belum_lunas']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('kategori_transaksi');
        Schema::dropIfExists('list_transaksi');
        Schema::dropIfExists('list_cicil_transaksi');
    }
};
