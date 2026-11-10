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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 40)->unique();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();
    
            $table->foreignId('cupon_id')
                ->nullable()
                ->constrained('cupones')
                ->nullOnDelete();
    
            // Guardamos el código aunque posteriormente se elimine el cupón.
            $table->string('cupon_codigo', 100)->nullable();
    
            $table->string('estado', 30)->default('pendiente');
            $table->string('estado_pago', 30)->default('pendiente');
    
            $table->string('metodo_pago', 50)->nullable();
            $table->string('referencia_pago', 150)->nullable();
            $table->dateTime('fecha_pago')->nullable();
    
            $table->string('tipo_entrega', 30)->default('domicilio');
    
            // Copia de la dirección utilizada al realizar el pedido.
            // Será null para recogida en tienda.
            $table->json('direccion_entrega')->nullable();
    
            // Conservamos también el nombre de la zona de envío.
            $table->string('zona_envio')->nullable();
    
            $table->decimal('subtotal_original', 10, 2)->default(0);
            $table->decimal('descuento_promociones', 10, 2)->default(0);
            $table->decimal('descuento_cupon', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('costo_envio', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
    
            $table->char('moneda', 3)->default('MXN');
    
            $table->text('notas')->nullable();
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};