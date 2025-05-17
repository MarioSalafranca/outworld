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
        Schema::create('drinks_imagenes', function (Blueprint $table) {
            $table->id();
            $table->string('ruta');
            $table->timestamps();
            $table->foreignId('drink_id')->constrained('drinks')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drinks_imagenes');
    }
};
