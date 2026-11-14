<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Intentos de pago
        |--------------------------------------------------------------------------
        */

        Schema::create('checkout_intentos', function (Blueprint $table) {
            $table->id();

            // Identificador único que también utilizaremos como
            // external_reference al comunicarnos con Mercado Pago.
            $table->uuid('referencia_externa')->unique();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Se conservará el intento aunque posteriormente
            // se elimine el cupón.
            $table->foreignId('cupon_id')
                ->nullable()
                ->constrained('cupones')
                ->nullOnDelete();

            // Se asignará cuando el pago aprobado genere la orden.
            $table->foreignId('orden_id')
                ->nullable()
                ->unique()
                ->constrained('ordenes')
                ->nullOnDelete();

            /*
             * pendiente, procesando, aprobado, rechazado,
             * cancelado, expirado
             */
            $table->string('estado', 25)->default('pendiente');

            $table->string('metodo_pago', 50)->default('mercado_pago');

            $table->string('cupon_codigo', 100)->nullable();

            // Referencias devueltas por Mercado Pago.
            $table->string('mercadopago_order_id', 100)
                ->nullable()
                ->unique();

            $table->uuid('mercadopago_idempotency_key')
                ->unique();

            $table->text('mercadopago_checkout_url')->nullable();

            // Datos de entrega guardados como snapshot.
            $table->string('tipo_entrega', 30)->default('domicilio');
            $table->json('direccion_entrega')->nullable();
            $table->string('zona_envio')->nullable();

            // Importes calculados en el servidor.
            $table->decimal('subtotal_original', 10, 2)->default(0);
            $table->decimal('descuento_promociones', 10, 2)->default(0);
            $table->decimal('descuento_cupon', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('costo_envio', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            $table->char('moneda', 3)->default('MXN');

            // Fechas del ciclo de vida del intento.
            $table->timestamp('fecha_expiracion')->nullable();
            $table->timestamp('fecha_pago')->nullable();

            // Se establece al liberar el inventario por fallo,
            // cancelación o vencimiento.
            $table->timestamp('fecha_liberacion')->nullable();

            // Respuesta recibida de la pasarela para auditoría.
            $table->json('respuesta_pasarela')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'estado']);
            $table->index(['estado', 'fecha_expiracion']);
        });

        /*
        |--------------------------------------------------------------------------
        | Artículos del intento de pago
        |--------------------------------------------------------------------------
        */

        Schema::create('checkout_intento_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('checkout_intento_id')
                ->constrained('checkout_intentos')
                ->cascadeOnDelete();

            // Referencia polimórfica igual que en orden_items.
            // El snapshot conserva los datos aunque el producto cambie.
            $table->string('comprable_type');
            $table->unsignedBigInteger('comprable_id');

            $table->string('nombre_articulo');
            $table->string('sku')->nullable();
            $table->string('imagen')->nullable();
            $table->json('datos_articulo')->nullable();

            $table->unsignedInteger('cantidad');

            $table->decimal('precio_original_unitario', 10, 2);
            $table->decimal('precio_unitario', 10, 2);

            $table->decimal('subtotal_original', 10, 2);
            $table->decimal('subtotal', 10, 2);

            
            $table->index(['comprable_type', 'comprable_id']);
            
            $table->unique(
                [
                'checkout_intento_id',
                'comprable_type',
                'comprable_id',
                ],
                'checkout_intento_item_unico'
                );
            
            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | Vincular las reservas de cupones con los intentos
        |--------------------------------------------------------------------------
        */

        Schema::table('cupon_usos', function (Blueprint $table) {
            $table->foreignId('checkout_intento_id')
                ->nullable()
                ->unique()
                ->constrained('checkout_intentos')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cupon_usos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('checkout_intento_id');
        });

        Schema::dropIfExists('checkout_intento_items');
        Schema::dropIfExists('checkout_intentos');
    }
};