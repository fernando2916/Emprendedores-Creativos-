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
        Schema::create('variante_attributes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_variante_id')
                    ->constrained('producto_variantes')
                    ->cascadeOnDelete();

            $table->foreignId('producto_attribute_id')
                ->constrained('producto_attributes')
                ->cascadeOnDelete();

            $table->foreignId('attribute_value_id')
                ->constrained('attribute_values')
                ->cascadeOnDelete();
            
                $table->unique([
                'producto_variante_id',
                'producto_attribute_id',
            ]);
                
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variante_attributes');
    }
};