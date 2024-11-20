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
        Schema::create('data_ruangan', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('ruang', 255);
            $table->enum('time_available', [1, 2, 3]);
            $table->enum('day_available', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->text('lokasi');
            $table->integer('id_gedung');
            $table->enum('kampus', [1, 2]);
            $table->string('foto', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ruangan');
    }
};
