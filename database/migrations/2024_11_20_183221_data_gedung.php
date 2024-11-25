<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_gedung', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('gedung', 255);
            $table->enum('kampus', [1, 2]);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_gedung');
    }
};
