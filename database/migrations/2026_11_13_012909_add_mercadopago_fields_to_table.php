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
        Schema::table('ordenes', function (Blueprint $table) {
            $table->string('mercadopago_order_id')
            ->nullable()
            ->unique();

            $table->uuid('mercadopago_idempotency_key')
                ->nullable()
                ->unique();

            $table->text('mercadopago_checkout_url')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->dropUnique(['mercadopago_order_id']);
            $table->dropUnique(['mercadopago_idempotency_key']);

            $table->dropColumn([
                'mercadopago_order_id',
                'mercadopago_idempotency_key',
                'mercadopago_checkout_url',
            ]);
        });
    }
};