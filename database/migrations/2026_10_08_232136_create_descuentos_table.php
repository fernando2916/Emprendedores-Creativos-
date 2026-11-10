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
        Schema::create('descuentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();

            // porcentaje, importe_fijo o precio_fijo
            $table->string('tipo', 30);

            // Porcentaje, cantidad a descontar o precio final.
            $table->decimal('valor', 10, 2);

            // tienda, categoria o producto
            $table->string('alcance', 30);

            // Si no tiene fecha de inicio, podrá comenzar inmediatamente.
            $table->dateTime('fecha_inicio')->nullable();

            // La promoción tendrá una fecha de finalización obligatoria.
            $table->dateTime('fecha_fin');

            $table->boolean('estado')->default(true);

            $table->index(['estado', 'fecha_inicio', 'fecha_fin']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};