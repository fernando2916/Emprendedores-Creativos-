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
        Schema::create('producto_respuestas', function (Blueprint $table) {
            $table->id();

            // Puede pertenecer a una reseña o a una pregunta.
            $table->morphs('respondible');

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Permite respuestas anidadas.
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('producto_respuestas')
                ->nullOnDelete();

            $table->text('contenido');

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_respuestas');
    }
};