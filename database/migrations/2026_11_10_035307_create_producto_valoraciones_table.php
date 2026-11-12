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
        Schema::create('producto_valoraciones', function (Blueprint $table) {
            $table->id();
            $table->morphs('valoracionable');

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->boolean('util');

            
            // Un usuario solamente puede valorar una vez
            // cada reseña, pregunta o respuesta.
            $table->unique(
            ['valoracionable_type', 'valoracionable_id', 'user_id'],
            'producto_valoracion_usuario_unico'
            );
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_valoraciones');
    }
};