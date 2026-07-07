<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Paquete10MesasReservasResenas\Models\Zona;
use Modules\Paquete10MesasReservasResenas\Models\Mesa;

class MesasSeeder extends Seeder
{
    public function run()
    {
        // Asegurar que exista la columna fila en la tabla mesas
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE mesas ADD COLUMN IF NOT EXISTS fila INT DEFAULT 1;');
            DB::statement('TRUNCATE TABLE mesas RESTART IDENTITY CASCADE;');
            DB::statement('TRUNCATE TABLE zonas RESTART IDENTITY CASCADE;');
        } else {
            Schema::disableForeignKeyConstraints();
            DB::table('mesas')->truncate();
            DB::table('zonas')->truncate();
            Schema::enableForeignKeyConstraints();
        }

        $zonasNombres = ['Terraza', 'Salón Principal'];
        
        foreach ($zonasNombres as $nombre) {
            $zona = Zona::create(['nombre' => $nombre, 'estado' => true]);
            
            if ($nombre === 'Terraza') {
                // 4 mesas para terraza (2x2)
                $capacidades = [2, 2, 4, 4];
                $filas = [1, 1, 2, 2];
                for ($i = 1; $i <= 4; $i++) {
                    Mesa::create([
                        'zona_id' => $zona->id,
                        'numero' => 'M' . $i,
                        'capacidad' => $capacidades[$i - 1],
                        'estado' => 'libre',
                        'fila' => $filas[$i - 1]
                    ]);
                }
            } else {
                // 6 mesas para Salón Principal (3, 1, 2)
                $capacidades = [2, 4, 4, 6, 4, 8];
                $filas = [1, 1, 1, 2, 3, 3];
                for ($i = 1; $i <= 6; $i++) {
                    Mesa::create([
                        'zona_id' => $zona->id,
                        'numero' => 'M' . $i,
                        'capacidad' => $capacidades[$i - 1],
                        'estado' => 'libre',
                        'fila' => $filas[$i - 1]
                    ]);
                }
            }
        }
    }
}
