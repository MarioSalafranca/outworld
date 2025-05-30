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
        Schema::create('drink_instrumento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drink_id')->constrained('drinks')->onDelete('cascade');
            $table->foreignId('instrumento_id')->constrained('instrumentos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drink_instrumento');
    }
};
