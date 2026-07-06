<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('venta_detalles', function (Blueprint $table) {
            $table->unsignedBigInteger('id_producto')->nullable()->change();
            $table->unsignedBigInteger('id_combo')->nullable()->after('id_producto');
            
            $table->foreign('id_combo')->references('id')->on('combos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('venta_detalles', function (Blueprint $table) {
            $table->dropForeign(['id_combo']);
            $table->dropColumn('id_combo');
            $table->unsignedBigInteger('id_producto')->nullable(false)->change();
        });
    }
};
