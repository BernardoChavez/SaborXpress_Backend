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
        Schema::create('catering_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('cliente');
            $table->string('telefono')->nullable();
            $table->date('fecha_evento');
            $table->time('hora_evento');
            $table->string('direccion');
            $table->integer('cantidad_personas');
            $table->text('observaciones')->nullable();
            $table->decimal('precio_total', 10, 2)->default(0);
            $table->string('estado')->default('Pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catering_servicios');
    }
};
