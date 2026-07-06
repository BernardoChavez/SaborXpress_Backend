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
            $table->string('encargado')->nullable()->after('correo_destinatario');
        });

        Schema::table('inventario_alertas_generadas', function (Blueprint $table) {
            $table->string('encargado')->nullable()->after('correo_destinatario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventario_alertas_config', function (Blueprint $table) {
            $table->dropColumn('encargado');
        });

        Schema::table('inventario_alertas_generadas', function (Blueprint $table) {
            $table->dropColumn('encargado');
        });
    }
};
