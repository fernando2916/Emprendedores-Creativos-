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
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrito_id')
            ->constrained('carritos')
            ->cascadeOnDelete();

            /*
            * Referencia polimórfica al artículo comprado.
            *
            * Ejemplos futuros:
            * - ProductoVariante
            * - Modelo del recurso descargable
            * - Modelo del curso
            */
            $table->morphs('comprable');

            $table->unsignedInteger('cantidad')->default(1);
           
            // Evita duplicar la misma variante o artículo en un carrito.
            $table->unique(
                ['carrito_id', 'comprable_type', 'comprable_id'],
                'carrito_item_comprable_unique'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_items');
    }
};