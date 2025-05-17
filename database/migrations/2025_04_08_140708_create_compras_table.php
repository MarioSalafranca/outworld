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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('total', 10, 2);
            $table->decimal('envio', 10, 2);
            $table->string('email',255);
            $table->string('telefono',20);
            $table->string('calle',100);
            $table->string('ciudad',100);
            $table->string('cp',100);
            $table->string('numero',20);
            $table->string('pais',100);
            $table->timestamps();

            $table->string('usuario_user', 255)->nullable();
            $table->foreign('usuario_user')->references('usuario_user')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
