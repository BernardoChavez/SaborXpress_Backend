<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SaborXpressProyectSeeder::class,
            MesasSeeder::class,
            ResenasSeeder::class,
            MigracionLocalSeeder::class,
        ]);
    }
}