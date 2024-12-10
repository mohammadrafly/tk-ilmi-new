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
        Schema::create('tahunajaran', function (Blueprint $table) {
            $table->id();
            $table->integer('tahunawal')->unsigned();
            $table->integer('tahunakhir')->unsigned();
            $table->timestamps();
        });

        Schema::create('programsemester', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_ajaran')->constrained('tahunajaran')->onDelete('cascade');
            $table->string('semester');
            $table->string('bulan');
            $table->string('topik');
            $table->text('minggu1')->nullable();
            $table->text('minggu2')->nullable();
            $table->text('minggu3')->nullable();
            $table->text('minggu4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programsemester');
        Schema::dropIfExists('tahunajaran');
    }
};
