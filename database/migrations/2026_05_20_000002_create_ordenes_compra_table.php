<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes_compra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_proveedor')->constrained('proveedores')->onDelete('restrict');
            $table->foreignId('id_usuario')->constrained('autenticacion', 'id_persona')->onDelete('restrict');
            $table->decimal('monto_total', 10, 2);
            $table->enum('estado', ['Pendiente', 'Recibida', 'Cancelada'])->default('Pendiente');
            $table->timestamp('fecha_orden')->useCurrent();
            $table->timestamp('fecha_recepcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes_compra');
    }
};
