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
        Schema::create('cupon_usos', function (Blueprint $table) {
        $table->id();

        $table->foreignId('cupon_id')
            ->constrained('cupones')
            ->cascadeOnDelete();

        $table->foreignId('user_id')
            ->constrained('users')
            ->cascadeOnDelete();

        // Lo relacionaremos con la tabla de órdenes más adelante.
        $table->unsignedBigInteger('orden_id')->nullable()->unique();

        // usado o cancelado
        $table->string('estado', 20)->default('usado');

        $table->dateTime('usado_en')->nullable();

        
        $table->index(['cupon_id', 'estado']);
        $table->index(['cupon_id', 'user_id', 'estado']);
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupon_usos');
    }
};