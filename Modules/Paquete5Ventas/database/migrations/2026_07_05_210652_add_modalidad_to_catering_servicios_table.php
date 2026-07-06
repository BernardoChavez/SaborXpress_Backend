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
        Schema::table('catering_servicios', function (Blueprint $table) {
            $table->string('modalidad')->default('Servicio Externo');
            $table->string('direccion')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catering_servicios', function (Blueprint $table) {
            $table->dropColumn('modalidad');
            $table->string('direccion')->nullable(false)->change();
        });
    }
};
