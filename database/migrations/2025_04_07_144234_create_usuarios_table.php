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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('usuario_user',255)->primary();
            $table->string('email',255)->unique();
            $table->string('nombre',25);
            $table->string('apellido',25);
            $table->string('password', 300);
            $table->rememberToken();
            $table->string('telefono',20);
            $table->string('calle',100);
            $table->string('ciudad',100);
            $table->string('cp',100);
            $table->string('numero',20);
            $table->string('pais',100);
            $table->enum('rol',['admin','usuario'])->default('usuario');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
