<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('empresa', function (Blueprint $table) {
            $table->string('sucursal', 100)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('actividad_economica', 255)->nullable();
            $table->string('codigo_autorizacion', 255)->nullable();
            $table->text('leyenda_factura')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('empresa', function (Blueprint $table) {
            $table->dropColumn(['sucursal', 'ciudad', 'actividad_economica', 'codigo_autorizacion', 'leyenda_factura']);
        });
    }
};
