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
        Schema::create('zonas_envio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);

            $table->text('descripcion')->nullable();

            // Tarifa normal de envío de la zona.
            $table->decimal('tarifa', 10, 2)->default(0);

            // NULL significa que no hay umbral de envío gratis.
            $table->decimal(
                'monto_minimo_envio_gratis',
                10,
                2
            )->nullable();

            $table->boolean('activa')->default(true);

            $table->index('activa');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zonas_envio');
    }
};