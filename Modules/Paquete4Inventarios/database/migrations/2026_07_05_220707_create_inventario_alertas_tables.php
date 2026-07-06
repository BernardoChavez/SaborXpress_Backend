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
        Schema::create('inventario_alertas_config', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_inventario'); // bruto, procesado
            $table->unsignedBigInteger('inventario_id');
            $table->boolean('alerta_activa')->default(true);
            $table->string('correo_destinatario')->nullable();
            $table->timestamps();
            
            $table->unique(['tipo_inventario', 'inventario_id']);
        });

        Schema::create('inventario_alertas_generadas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('tipo_inventario'); // bruto, procesado
            $table->unsignedBigInteger('inventario_id');
            $table->decimal('stock_actual', 10, 2);
            $table->decimal('stock_minimo', 10, 2);
            $table->string('estado')->default('Pendiente'); // Pendiente, Atendida
            $table->timestamp('fecha_envio_correo')->nullable();
            $table->string('correo_destinatario')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario_alertas_generadas');
        Schema::dropIfExists('inventario_alertas_config');
    }
};
