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
        Schema::create('codigos_descuento', function (Blueprint $table) {
            $table->id();
            $table->string("codigo",20)->unique();
            $table->date("validez");
            $table->decimal('porcentaje', 5, 2);
            $table->timestamps();

            $table->foreignId('compra_id')->nullable()->unique()->constrained('compras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codigos_descuento');
    }
};
