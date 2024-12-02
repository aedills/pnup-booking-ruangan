<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_ruangan', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('ruang', 255);
            $table->string('time_available', 100);
            $table->string('day_available', 200);
            $table->text('lokasi');
            $table->integer('id_gedung');
            $table->enum('kampus', [1, 2]);
            $table->string('foto', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_ruangan');
    }
};
