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
        Schema::create('zona_envio_codigos_postales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zona_envio_id')
            ->constrained('zonas_envio')
            ->cascadeOnDelete();

        // Se guarda como texto para conservar ceros iniciales.
        $table->string('codigo_postal', 5);

        // Cada CP solo puede asignarse a una zona.
        $table->unique('codigo_postal');
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zona_envio_codigos_postales');
    }
};