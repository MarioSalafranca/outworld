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
        Schema::table('drinks', function (Blueprint $table) {
            $table->foreignId('tipo_coctel_id')->nullable()->constrained('categoria_drinks')->onDelete('cascade');
            $table->foreignId('base_sabor_id')->nullable()->constrained('categoria_drinks')->onDelete('cascade');
            $table->foreignId('tiempo_preparacion_id')->nullable()->constrained('categoria_drinks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drinks', function (Blueprint $table) {
            $table->dropForeign(['tipo_coctel_id']);
            $table->dropForeign(['base_sabor_id']);
            $table->dropForeign(['tiempo_preparacion_id']);
            $table->dropColumn(['tipo_coctel_id', 'base_sabor_id', 'tiempo_preparacion_id']);
        });
    }
};
