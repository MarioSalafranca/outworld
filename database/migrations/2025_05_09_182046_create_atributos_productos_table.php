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
        Schema::create('atributos_productos', function (Blueprint $table) {
            $table->id();
            $table->text('sabor');
            $table->text('tamanio');
            $table->text('porcentaje_alcohol');
            $table->text('metodo_destilacion');
            $table->text('color');
            $table->foreignId('producto_id')->constrained('productos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atributos_productos');
    }
};
