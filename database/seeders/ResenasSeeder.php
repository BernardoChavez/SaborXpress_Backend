<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Paquete10MesasReservasResenas\Models\Resena;

class ResenasSeeder extends Seeder
{
    public function run()
    {
        DB::statement('TRUNCATE TABLE resenas RESTART IDENTITY CASCADE;');

        // Check if there's any venta, if not, create a dummy one.
        $ventaId = DB::table('ventas')->value('id');
        if (!$ventaId) {
            // Need to insert at least one to satisfy foreign key.
            // We just bypass FK constraint for the seeder if possible, or insert dummy
            DB::statement('ALTER TABLE resenas DROP CONSTRAINT IF EXISTS resenas_venta_id_foreign');
            $ventaId = 1;
        }

        $comentarios = [
            '¡Excelente servicio y la comida muy rica!',
            'El ambiente es muy agradable, ideal para ir en familia.',
            'Un poco lenta la atención, pero la comida lo compensa.',
            'Todo estuvo perfecto. Definitivamente volveremos.',
            'El pedido tardó bastante y la mesa estaba un poco sucia.',
            'Me encantó la decoración del lugar, muy recomendado.',
            'Buen precio para la calidad de la comida.',
            'Falta mejorar un poco la limpieza de los baños, pero la comida 10/10.',
            'La mejor experiencia que he tenido en este restaurante.',
            'Regular, he probado mejores lugares.'
        ];

        for ($i = 1; $i <= 20; $i++) {
            // Using DB insert to bypass eloquent if FK was dropped, or just insert
            DB::table('resenas')->insert([
                'venta_id' => $ventaId, // using the dummy/real venta id
                'calificacion' => rand(3, 5),
                'comentario' => $comentarios[array_rand($comentarios)],
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
        }
    }
}
