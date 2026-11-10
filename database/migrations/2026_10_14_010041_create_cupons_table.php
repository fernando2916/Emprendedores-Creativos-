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
        Schema::create('cupones', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 150);
            $table->string('codigo', 60)->unique();
            $table->text('descripcion')->nullable();

            // porcentaje o importe_fijo
            $table->string('tipo', 30);

            // Porcentaje o cantidad que se descontará.
            $table->decimal('valor', 10, 2);

            // tienda, categoria o articulo
            $table->string('alcance', 30);

            // Subtotal mínimo de los artículos elegibles.
            $table->decimal('monto_minimo_compra', 10, 2)
                ->nullable();

            // NULL representa un límite sin definir.
            $table->unsignedInteger('max_usos_global')->nullable();

            $table->unsignedInteger('max_usos_por_usuario')
                ->nullable();

            $table->dateTime('fecha_inicio')->nullable();

            $table->dateTime('fecha_fin')->nullable();

            $table->boolean('estado')->default(true);

            
            $table->index([
            'estado',
            'fecha_inicio',
            'fecha_fin',
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupones');
    }
};