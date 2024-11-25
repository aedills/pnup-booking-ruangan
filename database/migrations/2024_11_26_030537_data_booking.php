<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_booking', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('nama', 255);
            $table->string('no_hp', 14);
            $table->text('agenda_rapat');
            $table->date('tanggal');
            $table->string('uuid_ruang');
            $table->enum('kode_waktu', [1, 2, 3]);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_booking');
    }
};
