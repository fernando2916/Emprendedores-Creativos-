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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();
            
            // Nombre que el usuario asigna a la dirección.
            // Ejemplo: Casa, Oficina.
            $table->string('alias', 60)->nullable();
            
            // Datos de quien recibe el paquete.
            $table->string('destinatario', 150);
            $table->string('telefono_contacto', 20);

            // Domicilio.
            $table->string('calle', 150);
            $table->string('numero_exterior', 30);
            $table->string('numero_interior', 30)->nullable();

            // Datos postales de México.
            $table->string('codigo_postal', 5);
            $table->string('colonia', 150);
            $table->string('municipio', 150);
            $table->string('estado', 100);
            $table->string('pais', 60)->default('México');

            $table->text('referencias')->nullable();

            $table->boolean('predeterminada')->default(false);

            $table->index(['user_id', 'predeterminada']);
            $table->index('codigo_postal');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};