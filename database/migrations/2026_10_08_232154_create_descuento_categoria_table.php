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
        Schema::create('descuento_categoria', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('descuento_id')
            ->constrained('descuentos')
            ->cascadeOnDelete();

            $table->foreignId('categoria_id')
            ->constrained('categorias')
            ->cascadeOnDelete();

            $table->unique(['descuento_id', 'categoria_id']);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuento_categoria');
    }
};