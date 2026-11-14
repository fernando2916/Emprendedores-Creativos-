<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {

            // Decisión del cliente cuando el pedido queda sin stock.
            // Valores: pendiente, esperar, reembolso, sin_respuesta.
            $table->string('decision_stock', 30)
                ->nullable();

            // Control del plazo de 7 días.
            $table->timestamp('fecha_notificacion_stock')
                ->nullable();

            $table->timestamp('fecha_limite_decision_stock')
                ->nullable();

            $table->timestamp('fecha_decision_stock')
                ->nullable();

            // Seguimiento del reembolso.
            // Valores: pendiente, procesando, reembolsado, fallido.
            $table->string('estado_reembolso', 30)
                ->nullable();

            $table->string('mercadopago_refund_id')
                ->nullable();

            $table->timestamp('fecha_reembolso')
                ->nullable();

            $table->text('motivo_reembolso')
                ->nullable();

            $table->index(
                ['estado', 'estado_pago'],
                'ordenes_estado_pago_idx'
            );

            $table->index(
                ['decision_stock', 'fecha_limite_decision_stock'],
                'ordenes_decision_stock_idx'
            );
        });

        Schema::create('orden_stock_esperas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('orden_id')
                ->constrained('ordenes')
                ->cascadeOnDelete();

            $table->foreignId('orden_item_id')
                ->unique()
                ->constrained('orden_items')
                ->cascadeOnDelete();

            $table->foreignId('producto_variante_id')
                ->constrained('producto_variantes')
                ->restrictOnDelete();

            // Cantidad completa que necesita ese artículo.
            $table->unsignedInteger('cantidad');

            // pendiente: todavía no se ha asignado inventario.
            // asignado: ya se descontó el inventario.
            $table->string('estado', 20)
                ->default('pendiente');

            $table->timestamp('asignado_en')
                ->nullable();

                
                $table->index(
                ['estado', 'producto_variante_id'],
                'orden_stock_variante_idx'
                );
                
                $table->index(
                ['orden_id', 'estado'],
                'orden_stock_orden_idx'
                );
                
                $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orden_stock_esperas');

        Schema::table('ordenes', function (Blueprint $table) {

            $table->dropIndex('ordenes_estado_pago_idx');
            $table->dropIndex('ordenes_decision_stock_idx');

            $table->dropColumn([
                'decision_stock',
                'fecha_notificacion_stock',
                'fecha_limite_decision_stock',
                'fecha_decision_stock',
                'estado_reembolso',
                'mercadopago_refund_id',
                'fecha_reembolso',
                'motivo_reembolso',
            ]);
        });
    }
};