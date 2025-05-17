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
        Schema::create('reseñas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('drink_id')->constrained('drinks')->onDelete('cascade');
            $table->string('usuario')->nullable(); // Nombre del usuario
            $table->text('comentario')->nullable();
            $table->integer('valoracion')->default(0); // Valoración del 1 al 5
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
