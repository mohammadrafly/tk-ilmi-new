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
        Schema::create('programsemester', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran');
            $table->string('semester');
            $table->string('bulan');
            $table->string('topik');
            $table->string('minggu1');
            $table->string('minggu2');
            $table->string('minggu3');
            $table->string('minggu4');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programsemester');
    }
};
