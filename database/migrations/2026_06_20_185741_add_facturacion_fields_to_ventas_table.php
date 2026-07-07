<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First drop the CHECK constraint that laravel created for ENUM
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE ventas DROP CONSTRAINT IF EXISTS ventas_estado_check");
        }

        Schema::table('ventas', function (Blueprint $table) {
            // Now add the new CHECK constraint
            if (DB::getDriverName() === 'pgsql') {
                DB::statement("ALTER TABLE ventas ADD CONSTRAINT ventas_estado_check CHECK (estado::text = ANY (ARRAY['Pendiente'::character varying, 'Pagado'::character varying, 'Cancelado'::character varying, 'Anulado'::character varying]::text[]))");
            }

            $table->boolean('requiere_factura')->default(false);
            $table->string('nit_cliente', 50)->nullable();
            $table->string('nombre_cliente', 255)->nullable();
            $table->string('telefono_cliente', 50)->nullable();
            $table->integer('nro_factura')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn(['requiere_factura', 'nit_cliente', 'nombre_cliente', 'telefono_cliente', 'nro_factura']);
        });
        
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE ventas DROP CONSTRAINT IF EXISTS ventas_estado_check");
            DB::statement("ALTER TABLE ventas ADD CONSTRAINT ventas_estado_check CHECK (estado::text = ANY (ARRAY['Pendiente'::character varying, 'Pagado'::character varying, 'Cancelado'::character varying]::text[]))");
        }
    }
};
