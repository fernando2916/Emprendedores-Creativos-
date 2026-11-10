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
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_attribute_id')
                ->constrained('producto_attributes')
                ->cascadeOnDelete();

            $table->string('valor');
            $table->string('slug');
            $table->string('codigo')->nullable();

            $table->timestamps();

            $table->unique([
                'producto_attribute_id',
                'slug'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};