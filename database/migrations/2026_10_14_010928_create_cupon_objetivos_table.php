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
        Schema::create('cupon_objetivos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cupon_id')
                ->constrained('cupones')
                ->cascadeOnDelete();

            // categoria o articulo
            $table->string('tipo_objetivo', 20);

            // Modelo concreto al que se dirige el cupón.
            $table->string('objetivo_type', 150);
            $table->unsignedBigInteger('objetivo_id');

            
            // Evitar asociar dos veces el mismo objetivo al cupón.
            $table->unique(
            [
            'cupon_id',
            'tipo_objetivo',
            'objetivo_type',
            'objetivo_id',
            ],
            'cupon_objetivos_unicos'
            );
            
            $table->index([
            'objetivo_type',
            'objetivo_id',
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupon_objetivos');
    }
};