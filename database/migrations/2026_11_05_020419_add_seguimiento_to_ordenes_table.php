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
            $table->string('paqueteria', 100)->nullable();
            $table->string('numero_guia', 150)->nullable();
            $table->string('url_rastreo', 2048)->nullable();

            $table->timestamp('fecha_envio')->nullable();
            $table->timestamp('fecha_entrega')->nullable();

            $table->text('notas_admin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes', function (Blueprint $table) {
            $table->dropColumn([
                'paqueteria',
                'numero_guia',
                'url_rastreo',
                'fecha_envio',
                'fecha_entrega',
                'notas_admin',
            ]);
        });
    }
};