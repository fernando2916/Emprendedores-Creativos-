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
        Schema::create('orden_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')
            ->constrained('ordenes')
            ->cascadeOnDelete();

            // Permite relacionar variantes, descargas o cursos.
            $table->morphs('comprable');

            // Datos históricos del artículo al comprar.
            $table->string('nombre_articulo');
            $table->string('sku')->nullable();
            $table->string('imagen')->nullable();
            $table->json('datos_articulo')->nullable();

            $table->unsignedInteger('cantidad');

            $table->decimal('precio_original_unitario', 10, 2);
            $table->decimal('precio_unitario', 10, 2);

            $table->decimal('subtotal_original', 10, 2);
            $table->decimal('subtotal', 10, 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_items');
    }
};