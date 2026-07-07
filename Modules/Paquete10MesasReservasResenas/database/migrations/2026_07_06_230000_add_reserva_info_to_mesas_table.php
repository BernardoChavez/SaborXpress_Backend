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
        Schema::table('mesas', function (Blueprint $table) {
            if (!Schema::hasColumn('mesas', 'reserva_nombre')) {
                $table->string('reserva_nombre')->nullable();
                $table->string('reserva_telefono')->nullable();
                $table->string('reserva_hora')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mesas', function (Blueprint $table) {
            $table->dropColumn(['reserva_nombre', 'reserva_telefono', 'reserva_hora']);
        });
    }
};
