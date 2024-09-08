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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('alamat');
            $table->text('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->integer('agama_id');
            $table->string('foto_siswa')->nullable();
            $table->string('foto_akte_kelahiran')->nullable();
            $table->string('nama_orang_tua');
            $table->string('alamat_orang_tua');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
