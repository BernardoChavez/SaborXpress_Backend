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
        Schema::table('inventario_alertas_config', function (Blueprint $table) {
            $table->string('correo_remitente')->nullable()->after('alerta_activa');
        });

        Schema::table('inventario_alertas_generadas', function (Blueprint $table) {
            $table->string('correo_remitente')->nullable()->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventario_alertas_config', function (Blueprint $table) {
            $table->dropColumn('correo_remitente');
        });

        Schema::table('inventario_alertas_generadas', function (Blueprint $table) {
            $table->dropColumn('correo_remitente');
        });
    }
};
