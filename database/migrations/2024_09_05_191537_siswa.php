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
            $table->text('alamat')->nullable();
            $table->text('tempat_lahir')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->integer('agama_id')->nullable();
            $table->string('foto_akte_kelahiran')->nullable();
            $table->string('nama_orang_tua')->nullable();
            $table->string('alamat_orang_tua')->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable();
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
