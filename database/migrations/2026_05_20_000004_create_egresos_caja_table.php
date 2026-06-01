<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('egresos_caja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_caja')->constrained('cajas')->onDelete('restrict');
            $table->foreignId('id_usuario')->constrained('autenticacion', 'id_persona')->onDelete('restrict');
            $table->decimal('monto', 10, 2);
            $table->string('motivo', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('egresos_caja');
    }
};
