<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigracionLocalSeeder extends Seeder
{
    public function run(): void
    {
        // Tabla: persona (7 registros)
        try { DB::table('persona')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'nombre' => 'Bernardo Admin',
  'telefono' => '70011223',
  'created_at' => '2026-05-06 05:06:42',
  'updated_at' => '2026-05-06 05:06:42',
)); } catch (\Exception $e) {}
        try { DB::table('persona')->updateOrInsert(['id' => 2], array (
  'id' => 2,
  'nombre' => 'Juan Cajero',
  'telefono' => '60055443',
  'created_at' => '2026-05-06 05:06:42',
  'updated_at' => '2026-05-06 05:06:42',
)); } catch (\Exception $e) {}
        try { DB::table('persona')->updateOrInsert(['id' => 4], array (
  'id' => 4,
  'nombre' => 'Bernardo Chavez',
  'telefono' => '78593512',
  'created_at' => '2026-05-06 05:13:39',
  'updated_at' => '2026-05-06 05:13:39',
)); } catch (\Exception $e) {}
        try { DB::table('persona')->updateOrInsert(['id' => 5], array (
  'id' => 5,
  'nombre' => 'Josue Chavez',
  'telefono' => '78531694',
  'created_at' => '2026-05-06 05:25:58',
  'updated_at' => '2026-05-06 05:25:58',
)); } catch (\Exception $e) {}
        try { DB::table('persona')->updateOrInsert(['id' => 6], array (
  'id' => 6,
  'nombre' => 'Diogo',
  'telefono' => '4532264',
  'created_at' => '2026-05-08 02:46:58',
  'updated_at' => '2026-05-08 02:46:58',
)); } catch (\Exception $e) {}
        try { DB::table('persona')->updateOrInsert(['id' => 7], array (
  'id' => 7,
  'nombre' => 'Katering Cairo',
  'telefono' => '12457896',
  'created_at' => '2026-05-14 16:46:38',
  'updated_at' => '2026-05-14 16:46:38',
)); } catch (\Exception $e) {}
        try { DB::table('persona')->updateOrInsert(['id' => 8], array (
  'id' => 8,
  'nombre' => 'Bernardo Chavez Padilla',
  'telefono' => '785935412',
  'created_at' => '2026-06-24 01:29:30',
  'updated_at' => '2026-06-24 01:29:30',
)); } catch (\Exception $e) {}

        // Tabla: autenticacion (7 registros)
        try { DB::table('autenticacion')->insert(array (
  'id_persona' => 5,
  'correo' => 'josue@gmail.com',
  'contrasena' => '$2y$12$xu7jop6pUsAnUu6eJHdjPefjoYHgwT/xQFPSTEKrvh7IehFR3SX66',
  'id_rol' => 4,
  'intentos_fallidos' => 0,
  'bloqueado_hasta' => NULL,
  'created_at' => '2026-05-06 05:25:59',
  'updated_at' => '2026-05-06 05:38:03',
)); } catch (\Exception $e) {}
        try { DB::table('autenticacion')->insert(array (
  'id_persona' => 6,
  'correo' => 'diogomars2020@gmail.com',
  'contrasena' => '$2y$12$NBTuTLiAmL31o6DTUhVYeeaUm3yh9uB.hmIjhHcbWE7ZbbC36sRau',
  'id_rol' => 4,
  'intentos_fallidos' => 1,
  'bloqueado_hasta' => NULL,
  'created_at' => '2026-05-08 02:46:58',
  'updated_at' => '2026-05-14 16:44:22',
)); } catch (\Exception $e) {}
        try { DB::table('autenticacion')->insert(array (
  'id_persona' => 2,
  'correo' => 'cajero@saborxpress.com',
  'contrasena' => '$2y$12$1BpKUW4He6oWridClzqS/uI1mKHO53RZ7sfVDmFTprsyDEEudOz/a',
  'id_rol' => 2,
  'intentos_fallidos' => 1,
  'bloqueado_hasta' => NULL,
  'created_at' => '2026-05-06 05:06:42',
  'updated_at' => '2026-05-14 16:45:43',
)); } catch (\Exception $e) {}
        try { DB::table('autenticacion')->insert(array (
  'id_persona' => 7,
  'correo' => 'Katering@gmail.com',
  'contrasena' => '$2y$12$WxGeNheyCMEY5ZBaQ2YGrOyJoTV8jBvizEwC0avMDHXqZTI0dhPzW',
  'id_rol' => 2,
  'intentos_fallidos' => 1,
  'bloqueado_hasta' => NULL,
  'created_at' => '2026-05-14 16:46:38',
  'updated_at' => '2026-05-14 17:14:12',
)); } catch (\Exception $e) {}
        try { DB::table('autenticacion')->insert(array (
  'id_persona' => 4,
  'correo' => 'bernardochavez595@gmail.com',
  'contrasena' => '$2y$12$6eLulDq9uGko0F39AwFzV.X2UKJzFGI1ptK1UfSY.3G9qtJ5ylWMO',
  'id_rol' => 3,
  'intentos_fallidos' => 0,
  'bloqueado_hasta' => NULL,
  'created_at' => '2026-05-06 05:13:39',
  'updated_at' => '2026-06-21 01:45:55',
)); } catch (\Exception $e) {}
        try { DB::table('autenticacion')->insert(array (
  'id_persona' => 8,
  'correo' => 'chavezbernardo738@gmail.com',
  'contrasena' => '$2y$12$vwsmAgkSrc.b2gWWBtxErecbZxxGB3IwAym5.7hyA4C5vpkAPi9zC',
  'id_rol' => 4,
  'intentos_fallidos' => 0,
  'bloqueado_hasta' => NULL,
  'created_at' => '2026-06-24 01:29:31',
  'updated_at' => '2026-06-24 01:29:31',
)); } catch (\Exception $e) {}
        try { DB::table('autenticacion')->insert(array (
  'id_persona' => 1,
  'correo' => 'admin@saborxpress.com',
  'contrasena' => '$2y$12$pHbtnq9hkqf/nq3iAaT2PerqefkQQdZRNodqqecJZf2wn93WfHqwK',
  'id_rol' => 1,
  'intentos_fallidos' => 0,
  'bloqueado_hasta' => NULL,
  'created_at' => '2026-05-06 05:06:42',
  'updated_at' => '2026-06-24 02:50:01',
)); } catch (\Exception $e) {}

        // Tabla: empresa (1 registros)
        try { DB::table('empresa')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'nombre' => 'SaborXpress',
  'nit' => '3860553012',
  'direccion' => 'Calle Juan Lanito 2790',
  'telefono' => '71687341',
  'correo' => 'contacto@saborxpress.com',
  'moneda' => 'Bs.',
  'created_at' => '2026-05-06 05:27:53',
  'updated_at' => '2026-06-20 23:10:17',
  'sucursal' => 'CASA MATRIZ - No. Punto de Venta 0',
  'ciudad' => 'Santa Cruz',
  'actividad_economica' => 'VENTA DE COMIDA Y BEBIDAS',
  'codigo_autorizacion' => '10826566B59A83FD8 0E4EADD1082A521E C4796E06A0716E299 A187AF75',
  'leyenda_factura' => 'ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAÍS, EL USO ILÍCITO SERÁ SANCIONADO PENALMENTE DE ACUERDO A LEY
Ley N° 453: La interrupción del servicio debe comunicarse con anterioridad a las Autoridades que correspondan y a los usuarios afectados.
"Este documento es la Representación Gráfica de un Documento Fiscal Digital emitido en una modalidad de facturación en línea"',
)); } catch (\Exception $e) {}

        // Tabla: categoria (5 registros)
        try { DB::table('categoria')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'nombre' => 'Pollos a la Brasa',
  'created_at' => '2026-05-06 05:06:42',
  'updated_at' => '2026-05-06 05:06:42',
)); } catch (\Exception $e) {}
        try { DB::table('categoria')->updateOrInsert(['id' => 2], array (
  'id' => 2,
  'nombre' => 'Hamburguesas',
  'created_at' => '2026-05-06 05:06:42',
  'updated_at' => '2026-05-06 05:06:42',
)); } catch (\Exception $e) {}
        try { DB::table('categoria')->updateOrInsert(['id' => 3], array (
  'id' => 3,
  'nombre' => 'Salchipapas',
  'created_at' => '2026-05-06 22:23:20',
  'updated_at' => '2026-05-06 22:23:20',
)); } catch (\Exception $e) {}
        try { DB::table('categoria')->updateOrInsert(['id' => 4], array (
  'id' => 4,
  'nombre' => 'Porciones',
  'created_at' => '2026-06-21 00:54:25',
  'updated_at' => '2026-06-21 00:54:25',
)); } catch (\Exception $e) {}
        try { DB::table('categoria')->updateOrInsert(['id' => 5], array (
  'id' => 5,
  'nombre' => 'Bebidas',
  'created_at' => '2026-06-21 00:57:14',
  'updated_at' => '2026-06-21 00:57:14',
)); } catch (\Exception $e) {}

        // Tabla: producto (10 registros)
        try { DB::table('producto')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'nombre' => 'Cuarto de Pollo',
  'descripcion' => 'Pierna con papas y ensalada',
  'precio_venta' => '25.00',
  'imagen_url' => NULL,
  'id_categoria' => 1,
  'created_at' => '2026-05-06 05:06:42',
  'updated_at' => '2026-05-06 05:06:42',
)); } catch (\Exception $e) {}
        try { DB::table('producto')->updateOrInsert(['id' => 2], array (
  'id' => 2,
  'nombre' => 'Hamburguesa Simple',
  'descripcion' => 'Carne, queso y salsas',
  'precio_venta' => '15.50',
  'imagen_url' => NULL,
  'id_categoria' => 2,
  'created_at' => '2026-05-06 05:06:42',
  'updated_at' => '2026-05-06 05:06:42',
)); } catch (\Exception $e) {}
        try { DB::table('producto')->updateOrInsert(['id' => 3], array (
  'id' => 3,
  'nombre' => 'Salchipapa Simple',
  'descripcion' => NULL,
  'precio_venta' => '15.00',
  'imagen_url' => NULL,
  'id_categoria' => 3,
  'created_at' => '2026-05-06 22:23:43',
  'updated_at' => '2026-05-06 22:23:43',
)); } catch (\Exception $e) {}
        try { DB::table('producto')->updateOrInsert(['id' => 4], array (
  'id' => 4,
  'nombre' => 'Salchipapa doble',
  'descripcion' => NULL,
  'precio_venta' => '25.00',
  'imagen_url' => NULL,
  'id_categoria' => 3,
  'created_at' => '2026-05-15 11:59:51',
  'updated_at' => '2026-05-15 11:59:51',
)); } catch (\Exception $e) {}
        try { DB::table('producto')->updateOrInsert(['id' => 5], array (
  'id' => 5,
  'nombre' => 'Pollo entero',
  'descripcion' => NULL,
  'precio_venta' => '80.00',
  'imagen_url' => NULL,
  'id_categoria' => 1,
  'created_at' => '2026-05-15 12:14:37',
  'updated_at' => '2026-05-15 12:14:37',
)); } catch (\Exception $e) {}
        try { DB::table('producto')->updateOrInsert(['id' => 6], array (
  'id' => 6,
  'nombre' => 'Porcion de papa',
  'descripcion' => NULL,
  'precio_venta' => '10.00',
  'imagen_url' => NULL,
  'id_categoria' => 4,
  'created_at' => '2026-06-21 00:56:11',
  'updated_at' => '2026-06-21 00:56:11',
)); } catch (\Exception $e) {}
        try { DB::table('producto')->updateOrInsert(['id' => 7], array (
  'id' => 7,
  'nombre' => 'Porcion de arroz',
  'descripcion' => NULL,
  'precio_venta' => '10.00',
  'imagen_url' => NULL,
  'id_categoria' => 4,
  'created_at' => '2026-06-21 00:56:30',
  'updated_at' => '2026-06-21 00:56:30',
)); } catch (\Exception $e) {}
        try { DB::table('producto')->updateOrInsert(['id' => 8], array (
  'id' => 8,
  'nombre' => 'Cocacola 2lt',
  'descripcion' => NULL,
  'precio_venta' => '20.00',
  'imagen_url' => NULL,
  'id_categoria' => 5,
  'created_at' => '2026-06-21 00:57:38',
  'updated_at' => '2026-06-21 00:57:38',
)); } catch (\Exception $e) {}
        try { DB::table('producto')->updateOrInsert(['id' => 9], array (
  'id' => 9,
  'nombre' => 'Cocacola personal',
  'descripcion' => NULL,
  'precio_venta' => '10.00',
  'imagen_url' => NULL,
  'id_categoria' => 5,
  'created_at' => '2026-06-21 00:58:16',
  'updated_at' => '2026-06-21 00:58:16',
)); } catch (\Exception $e) {}
        try { DB::table('producto')->updateOrInsert(['id' => 10], array (
  'id' => 10,
  'nombre' => 'Del Valle 2lt',
  'descripcion' => NULL,
  'precio_venta' => '20.00',
  'imagen_url' => NULL,
  'id_categoria' => 5,
  'created_at' => '2026-06-21 00:59:07',
  'updated_at' => '2026-06-21 00:59:07',
)); } catch (\Exception $e) {}

        // Tabla: zonas (2 registros)
        try { DB::table('zonas')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'nombre' => 'Terraza',
  'estado' => true,
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-05 03:19:48',
)); } catch (\Exception $e) {}
        try { DB::table('zonas')->updateOrInsert(['id' => 2], array (
  'id' => 2,
  'nombre' => 'Salón Principal',
  'estado' => true,
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-05 03:19:48',
)); } catch (\Exception $e) {}

        // Tabla: mesas (11 registros)
        try { DB::table('mesas')->updateOrInsert(['id' => 5], array (
  'id' => 5,
  'zona_id' => 2,
  'numero' => 'M1',
  'capacidad' => 2,
  'estado' => 'libre',
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-05 03:19:48',
  'fila' => 1,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}
        try { DB::table('mesas')->updateOrInsert(['id' => 6], array (
  'id' => 6,
  'zona_id' => 2,
  'numero' => 'M2',
  'capacidad' => 4,
  'estado' => 'libre',
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-05 03:19:48',
  'fila' => 1,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}
        try { DB::table('mesas')->updateOrInsert(['id' => 7], array (
  'id' => 7,
  'zona_id' => 2,
  'numero' => 'M3',
  'capacidad' => 4,
  'estado' => 'libre',
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-05 03:19:48',
  'fila' => 1,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}
        try { DB::table('mesas')->updateOrInsert(['id' => 9], array (
  'id' => 9,
  'zona_id' => 2,
  'numero' => 'M5',
  'capacidad' => 4,
  'estado' => 'libre',
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-05 03:19:48',
  'fila' => 3,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}
        try { DB::table('mesas')->updateOrInsert(['id' => 10], array (
  'id' => 10,
  'zona_id' => 2,
  'numero' => 'M6',
  'capacidad' => 8,
  'estado' => 'libre',
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-05 03:19:48',
  'fila' => 3,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}
        try { DB::table('mesas')->updateOrInsert(['id' => 8], array (
  'id' => 8,
  'zona_id' => 2,
  'numero' => 'M4',
  'capacidad' => 6,
  'estado' => 'ocupada',
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-05 03:28:19',
  'fila' => 2,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}
        try { DB::table('mesas')->updateOrInsert(['id' => 11], array (
  'id' => 11,
  'zona_id' => 2,
  'numero' => 'M7',
  'capacidad' => 2,
  'estado' => 'libre',
  'created_at' => '2026-07-05 03:28:28',
  'updated_at' => '2026-07-05 03:28:28',
  'fila' => 2,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}
        try { DB::table('mesas')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'zona_id' => 1,
  'numero' => 'M1',
  'capacidad' => 2,
  'estado' => 'ocupada',
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-06 23:43:33',
  'fila' => 1,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}
        try { DB::table('mesas')->updateOrInsert(['id' => 2], array (
  'id' => 2,
  'zona_id' => 1,
  'numero' => 'M2',
  'capacidad' => 2,
  'estado' => 'ocupada',
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-06 23:56:50',
  'fila' => 1,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}
        try { DB::table('mesas')->updateOrInsert(['id' => 4], array (
  'id' => 4,
  'zona_id' => 1,
  'numero' => 'M4',
  'capacidad' => 4,
  'estado' => 'libre',
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-06 23:59:50',
  'fila' => 2,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}
        try { DB::table('mesas')->updateOrInsert(['id' => 3], array (
  'id' => 3,
  'zona_id' => 1,
  'numero' => 'M3',
  'capacidad' => 4,
  'estado' => 'libre',
  'created_at' => '2026-07-05 03:19:48',
  'updated_at' => '2026-07-07 00:00:02',
  'fila' => 2,
  'reserva_nombre' => NULL,
  'reserva_telefono' => NULL,
  'reserva_hora' => NULL,
)); } catch (\Exception $e) {}

        // Tabla: combos (1 registros)
        try { DB::table('combos')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'nombre' => 'Combo Personal',
  'descripcion' => 'Para 1 persona',
  'precio_venta' => '30.00',
  'imagen' => NULL,
  'estado' => true,
  'created_at' => '2026-07-06 23:22:30',
  'updated_at' => '2026-07-06 23:22:30',
)); } catch (\Exception $e) {}

        // Tabla: combo_productos (2 registros)
        try { DB::table('combo_productos')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'combo_id' => 1,
  'producto_id' => 1,
  'cantidad' => 1,
  'created_at' => '2026-07-06 23:22:30',
  'updated_at' => '2026-07-06 23:22:30',
)); } catch (\Exception $e) {}
        try { DB::table('combo_productos')->updateOrInsert(['id' => 2], array (
  'id' => 2,
  'combo_id' => 1,
  'producto_id' => 8,
  'cantidad' => 1,
  'created_at' => '2026-07-06 23:22:30',
  'updated_at' => '2026-07-06 23:22:30',
)); } catch (\Exception $e) {}

        // Tabla: resenas (25 registros)
        try { DB::table('resenas')->updateOrInsert(['id' => 21], array (
  'id' => 21,
  'venta_id' => 40,
  'calificacion' => 3,
  'comentario' => 'Me parece bien lo ultimo que implementaron con el tema de las mesas pero mejoren coon el sabor porfavor.',
  'leido' => true,
  'created_at' => '2026-07-05 03:02:47',
  'updated_at' => '2026-07-05 03:10:25',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 14], array (
  'id' => 14,
  'venta_id' => 2,
  'calificacion' => 5,
  'comentario' => 'Regular, he probado mejores lugares.',
  'leido' => true,
  'created_at' => '2026-07-04 02:39:51',
  'updated_at' => '2026-07-05 03:10:26',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 8], array (
  'id' => 8,
  'venta_id' => 2,
  'calificacion' => 4,
  'comentario' => 'Todo estuvo perfecto. Definitivamente volveremos.',
  'leido' => true,
  'created_at' => '2026-07-04 02:39:51',
  'updated_at' => '2026-07-05 03:10:26',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 9], array (
  'id' => 9,
  'venta_id' => 2,
  'calificacion' => 4,
  'comentario' => 'Falta mejorar un poco la limpieza de los baños, pero la comida 10/10.',
  'leido' => true,
  'created_at' => '2026-07-04 02:39:51',
  'updated_at' => '2026-07-05 03:10:27',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 12], array (
  'id' => 12,
  'venta_id' => 2,
  'calificacion' => 3,
  'comentario' => 'El pedido tardó bastante y la mesa estaba un poco sucia.',
  'leido' => true,
  'created_at' => '2026-06-27 02:39:51',
  'updated_at' => '2026-07-05 03:10:29',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 3], array (
  'id' => 3,
  'venta_id' => 2,
  'calificacion' => 4,
  'comentario' => 'Regular, he probado mejores lugares.',
  'leido' => true,
  'created_at' => '2026-06-27 02:39:51',
  'updated_at' => '2026-07-05 03:10:30',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 15], array (
  'id' => 15,
  'venta_id' => 2,
  'calificacion' => 5,
  'comentario' => 'El ambiente es muy agradable, ideal para ir en familia.',
  'leido' => true,
  'created_at' => '2026-06-27 02:39:51',
  'updated_at' => '2026-07-05 03:10:31',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 6], array (
  'id' => 6,
  'venta_id' => 2,
  'calificacion' => 3,
  'comentario' => 'Buen precio para la calidad de la comida.',
  'leido' => true,
  'created_at' => '2026-06-23 02:39:51',
  'updated_at' => '2026-07-05 03:10:32',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 5], array (
  'id' => 5,
  'venta_id' => 2,
  'calificacion' => 3,
  'comentario' => 'Un poco lenta la atención, pero la comida lo compensa.',
  'leido' => true,
  'created_at' => '2026-06-29 02:39:51',
  'updated_at' => '2026-07-05 03:10:32',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 4], array (
  'id' => 4,
  'venta_id' => 2,
  'calificacion' => 3,
  'comentario' => 'Buen precio para la calidad de la comida.',
  'leido' => true,
  'created_at' => '2026-06-20 02:39:51',
  'updated_at' => '2026-07-05 03:10:33',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 16], array (
  'id' => 16,
  'venta_id' => 2,
  'calificacion' => 4,
  'comentario' => '¡Excelente servicio y la comida muy rica!',
  'leido' => true,
  'created_at' => '2026-06-20 02:39:51',
  'updated_at' => '2026-07-05 03:10:34',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 19], array (
  'id' => 19,
  'venta_id' => 2,
  'calificacion' => 3,
  'comentario' => 'El ambiente es muy agradable, ideal para ir en familia.',
  'leido' => true,
  'created_at' => '2026-06-22 02:39:51',
  'updated_at' => '2026-07-05 03:10:35',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 10], array (
  'id' => 10,
  'venta_id' => 2,
  'calificacion' => 3,
  'comentario' => 'El ambiente es muy agradable, ideal para ir en familia.',
  'leido' => true,
  'created_at' => '2026-06-20 02:39:51',
  'updated_at' => '2026-07-05 03:10:36',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 20], array (
  'id' => 20,
  'venta_id' => 2,
  'calificacion' => 3,
  'comentario' => 'El pedido tardó bastante y la mesa estaba un poco sucia.',
  'leido' => true,
  'created_at' => '2026-06-17 02:39:51',
  'updated_at' => '2026-07-05 03:10:37',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 11], array (
  'id' => 11,
  'venta_id' => 2,
  'calificacion' => 5,
  'comentario' => 'Regular, he probado mejores lugares.',
  'leido' => true,
  'created_at' => '2026-06-12 02:39:51',
  'updated_at' => '2026-07-05 03:10:37',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 2], array (
  'id' => 2,
  'venta_id' => 2,
  'calificacion' => 5,
  'comentario' => 'Falta mejorar un poco la limpieza de los baños, pero la comida 10/10.',
  'leido' => true,
  'created_at' => '2026-06-09 02:39:51',
  'updated_at' => '2026-07-05 03:10:40',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 18], array (
  'id' => 18,
  'venta_id' => 2,
  'calificacion' => 3,
  'comentario' => 'Falta mejorar un poco la limpieza de los baños, pero la comida 10/10.',
  'leido' => true,
  'created_at' => '2026-06-11 02:39:51',
  'updated_at' => '2026-07-05 03:10:40',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 17], array (
  'id' => 17,
  'venta_id' => 2,
  'calificacion' => 4,
  'comentario' => 'La mejor experiencia que he tenido en este restaurante.',
  'leido' => true,
  'created_at' => '2026-06-11 02:39:51',
  'updated_at' => '2026-07-05 03:10:41',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 13], array (
  'id' => 13,
  'venta_id' => 2,
  'calificacion' => 4,
  'comentario' => 'Me encantó la decoración del lugar, muy recomendado.',
  'leido' => true,
  'created_at' => '2026-06-08 02:39:51',
  'updated_at' => '2026-07-05 03:10:42',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 7], array (
  'id' => 7,
  'venta_id' => 2,
  'calificacion' => 5,
  'comentario' => 'La mejor experiencia que he tenido en este restaurante.',
  'leido' => true,
  'created_at' => '2026-06-06 02:39:51',
  'updated_at' => '2026-07-05 03:10:43',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'venta_id' => 2,
  'calificacion' => 3,
  'comentario' => 'El ambiente es muy agradable, ideal para ir en familia.',
  'leido' => true,
  'created_at' => '2026-06-05 02:39:51',
  'updated_at' => '2026-07-05 03:10:43',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 22], array (
  'id' => 22,
  'venta_id' => 41,
  'calificacion' => 1,
  'comentario' => 'Muy mala atencion ademas que la comida muy mal estado.',
  'leido' => true,
  'created_at' => '2026-07-05 03:30:57',
  'updated_at' => '2026-07-05 03:41:11',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 24], array (
  'id' => 24,
  'venta_id' => 44,
  'calificacion' => 3,
  'comentario' => 'mala atencion',
  'leido' => false,
  'created_at' => '2026-07-06 23:44:01',
  'updated_at' => '2026-07-06 23:44:01',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 23], array (
  'id' => 23,
  'venta_id' => 43,
  'calificacion' => 1,
  'comentario' => 'Mala experiencia , deberian mejorar o cambiar a la cajera estaba de mal humor ademas de la comida que le falto sabor.',
  'leido' => true,
  'created_at' => '2026-07-05 03:40:52',
  'updated_at' => '2026-07-06 23:46:30',
)); } catch (\Exception $e) {}
        try { DB::table('resenas')->updateOrInsert(['id' => 25], array (
  'id' => 25,
  'venta_id' => 45,
  'calificacion' => 5,
  'comentario' => 'Excelente atencion',
  'leido' => false,
  'created_at' => '2026-07-07 00:01:58',
  'updated_at' => '2026-07-07 00:01:58',
)); } catch (\Exception $e) {}

        // Tabla: inventario_bruto (8 registros)
        try { DB::table('inventario_bruto')->updateOrInsert(['id' => 3], array (
  'id' => 3,
  'nombre' => 'Pollo',
  'stock' => '12.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '1.00',
  'created_at' => '2026-05-08 02:52:20',
  'updated_at' => '2026-06-20 17:01:14',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_bruto')->updateOrInsert(['id' => 2], array (
  'id' => 2,
  'nombre' => 'Paquete de Chorizos',
  'stock' => '11.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '2.00',
  'created_at' => '2026-05-06 22:26:08',
  'updated_at' => '2026-06-20 17:01:14',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_bruto')->updateOrInsert(['id' => 5], array (
  'id' => 5,
  'nombre' => 'Paquete Coca Cola Personal',
  'stock' => '45.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '5.00',
  'created_at' => '2026-06-21 01:06:05',
  'updated_at' => '2026-06-21 01:18:02',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_bruto')->updateOrInsert(['id' => 4], array (
  'id' => 4,
  'nombre' => 'Paquete Coca Cola de 2 Lt',
  'stock' => '45.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '5.00',
  'created_at' => '2026-06-21 01:05:43',
  'updated_at' => '2026-06-21 01:18:18',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_bruto')->updateOrInsert(['id' => 6], array (
  'id' => 6,
  'nombre' => 'Paquete Del Valle 2 Lt',
  'stock' => '45.00',
  'unidad_medida' => 'kg',
  'stock_minimo' => '5.00',
  'created_at' => '2026-06-21 01:06:24',
  'updated_at' => '2026-06-21 01:18:31',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_bruto')->updateOrInsert(['id' => 8], array (
  'id' => 8,
  'nombre' => 'Bombilla',
  'stock' => '8.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '5.00',
  'created_at' => '2026-06-24 01:47:08',
  'updated_at' => '2026-06-24 01:48:50',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_bruto')->updateOrInsert(['id' => 7], array (
  'id' => 7,
  'nombre' => 'Saco de Arroz',
  'stock' => '8.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '1.00',
  'created_at' => '2026-06-21 01:07:18',
  'updated_at' => '2026-06-24 01:53:47',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_bruto')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'nombre' => 'Saco de Papas',
  'stock' => '0.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '1.00',
  'created_at' => '2026-05-06 22:25:33',
  'updated_at' => '2026-07-06 23:28:48',
)); } catch (\Exception $e) {}

        // Tabla: inventario_procesado (8 registros)
        try { DB::table('inventario_procesado')->updateOrInsert(['id' => 7], array (
  'id' => 7,
  'nombre' => 'Del Valle 2Lt',
  'stock' => '-5.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '5.00',
  'created_at' => '2026-06-21 01:14:14',
  'updated_at' => '2026-07-05 03:39:58',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_procesado')->updateOrInsert(['id' => 2], array (
  'id' => 2,
  'nombre' => 'Chorizo Troceado',
  'stock' => '46.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '2.00',
  'created_at' => '2026-05-06 22:30:51',
  'updated_at' => '2026-07-06 23:43:18',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_procesado')->updateOrInsert(['id' => 3], array (
  'id' => 3,
  'nombre' => 'Presas de pollo',
  'stock' => '-2.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '1.00',
  'created_at' => '2026-05-08 02:52:56',
  'updated_at' => '2026-07-06 23:58:21',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_procesado')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'nombre' => 'Papa Picada',
  'stock' => '33.60',
  'unidad_medida' => 'kg',
  'stock_minimo' => '5.00',
  'created_at' => '2026-05-06 22:30:29',
  'updated_at' => '2026-07-06 23:58:21',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_procesado')->updateOrInsert(['id' => 4], array (
  'id' => 4,
  'nombre' => 'Arroz',
  'stock' => '46.70',
  'unidad_medida' => 'kg',
  'stock_minimo' => '2.00',
  'created_at' => '2026-06-21 01:08:11',
  'updated_at' => '2026-07-06 23:58:21',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_procesado')->updateOrInsert(['id' => 5], array (
  'id' => 5,
  'nombre' => 'Coca Cola 2Lt',
  'stock' => '-1.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '5.00',
  'created_at' => '2026-06-21 01:13:26',
  'updated_at' => '2026-07-06 23:58:21',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_procesado')->updateOrInsert(['id' => 8], array (
  'id' => 8,
  'nombre' => 'BombillaU',
  'stock' => '83.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '5.00',
  'created_at' => '2026-06-24 01:47:28',
  'updated_at' => '2026-07-06 23:58:21',
)); } catch (\Exception $e) {}
        try { DB::table('inventario_procesado')->updateOrInsert(['id' => 6], array (
  'id' => 6,
  'nombre' => 'Coca Cola Personal',
  'stock' => '0.00',
  'unidad_medida' => 'u',
  'stock_minimo' => '5.00',
  'created_at' => '2026-06-21 01:13:51',
  'updated_at' => '2026-07-05 03:35:08',
)); } catch (\Exception $e) {}

        // Tabla: recetas (18 registros)
        try { DB::table('recetas')->updateOrInsert(['id' => 1], array (
  'id' => 1,
  'id_producto' => 3,
  'id_procesado' => 1,
  'cantidad' => '0.30',
  'created_at' => '2026-05-06 22:32:51',
  'updated_at' => '2026-05-06 22:32:51',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 2], array (
  'id' => 2,
  'id_producto' => 3,
  'id_procesado' => 2,
  'cantidad' => '1.00',
  'created_at' => '2026-05-06 22:33:05',
  'updated_at' => '2026-05-06 22:33:05',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 3], array (
  'id' => 3,
  'id_producto' => 1,
  'id_procesado' => 3,
  'cantidad' => '2.00',
  'created_at' => '2026-05-08 02:54:01',
  'updated_at' => '2026-05-08 02:54:01',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 4], array (
  'id' => 4,
  'id_producto' => 1,
  'id_procesado' => 1,
  'cantidad' => '0.30',
  'created_at' => '2026-05-08 02:54:21',
  'updated_at' => '2026-05-08 02:54:21',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 6], array (
  'id' => 6,
  'id_producto' => 7,
  'id_procesado' => 4,
  'cantidad' => '0.30',
  'created_at' => '2026-06-21 01:11:41',
  'updated_at' => '2026-06-21 01:11:41',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 7], array (
  'id' => 7,
  'id_producto' => 6,
  'id_procesado' => 1,
  'cantidad' => '0.30',
  'created_at' => '2026-06-21 01:11:53',
  'updated_at' => '2026-06-21 01:11:53',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 8], array (
  'id' => 8,
  'id_producto' => 5,
  'id_procesado' => 3,
  'cantidad' => '4.00',
  'created_at' => '2026-06-21 01:19:27',
  'updated_at' => '2026-06-21 01:19:27',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 10], array (
  'id' => 10,
  'id_producto' => 5,
  'id_procesado' => 4,
  'cantidad' => '0.30',
  'created_at' => '2026-06-21 01:19:51',
  'updated_at' => '2026-06-21 01:19:51',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 11], array (
  'id' => 11,
  'id_producto' => 5,
  'id_procesado' => 1,
  'cantidad' => '0.30',
  'created_at' => '2026-06-21 01:19:56',
  'updated_at' => '2026-06-21 01:19:56',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 12], array (
  'id' => 12,
  'id_producto' => 8,
  'id_procesado' => 5,
  'cantidad' => '1.00',
  'created_at' => '2026-06-21 01:20:15',
  'updated_at' => '2026-06-21 01:20:15',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 13], array (
  'id' => 13,
  'id_producto' => 10,
  'id_procesado' => 7,
  'cantidad' => '1.00',
  'created_at' => '2026-06-21 01:20:24',
  'updated_at' => '2026-06-21 01:20:24',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 14], array (
  'id' => 14,
  'id_producto' => 9,
  'id_procesado' => 6,
  'cantidad' => '1.00',
  'created_at' => '2026-06-21 01:20:36',
  'updated_at' => '2026-06-21 01:20:36',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 15], array (
  'id' => 15,
  'id_producto' => 1,
  'id_procesado' => 4,
  'cantidad' => '0.30',
  'created_at' => '2026-06-21 01:20:53',
  'updated_at' => '2026-06-21 01:20:53',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 16], array (
  'id' => 16,
  'id_producto' => 4,
  'id_procesado' => 2,
  'cantidad' => '0.50',
  'created_at' => '2026-06-21 01:21:15',
  'updated_at' => '2026-06-21 01:21:15',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 17], array (
  'id' => 17,
  'id_producto' => 4,
  'id_procesado' => 1,
  'cantidad' => '0.50',
  'created_at' => '2026-06-21 01:21:24',
  'updated_at' => '2026-06-21 01:21:24',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 18], array (
  'id' => 18,
  'id_producto' => 8,
  'id_procesado' => 8,
  'cantidad' => '1.00',
  'created_at' => '2026-06-24 01:49:13',
  'updated_at' => '2026-06-24 01:49:13',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 19], array (
  'id' => 19,
  'id_producto' => 9,
  'id_procesado' => 8,
  'cantidad' => '1.00',
  'created_at' => '2026-06-24 01:49:22',
  'updated_at' => '2026-06-24 01:49:22',
)); } catch (\Exception $e) {}
        try { DB::table('recetas')->updateOrInsert(['id' => 20], array (
  'id' => 20,
  'id_producto' => 10,
  'id_procesado' => 8,
  'cantidad' => '1.00',
  'created_at' => '2026-06-24 01:49:29',
  'updated_at' => '2026-06-24 01:49:29',
)); } catch (\Exception $e) {}

        if (config('database.default') === 'pgsql') {
            try { $max = DB::table('paquete')->max('id'); if ($max) { DB::statement("SELECT setval('paquete_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('caso_uso')->max('id'); if ($max) { DB::statement("SELECT setval('caso_uso_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('rol')->max('id'); if ($max) { DB::statement("SELECT setval('rol_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('permiso_rol')->max('id'); if ($max) { DB::statement("SELECT setval('permiso_rol_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('persona')->max('id'); if ($max) { DB::statement("SELECT setval('persona_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('autenticacion')->max('id'); if ($max) { DB::statement("SELECT setval('autenticacion_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('empresa')->max('id'); if ($max) { DB::statement("SELECT setval('empresa_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('categoria')->max('id'); if ($max) { DB::statement("SELECT setval('categoria_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('producto')->max('id'); if ($max) { DB::statement("SELECT setval('producto_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('zonas')->max('id'); if ($max) { DB::statement("SELECT setval('zonas_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('mesas')->max('id'); if ($max) { DB::statement("SELECT setval('mesas_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('combos')->max('id'); if ($max) { DB::statement("SELECT setval('combos_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('combo_productos')->max('id'); if ($max) { DB::statement("SELECT setval('combo_productos_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('resenas')->max('id'); if ($max) { DB::statement("SELECT setval('resenas_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('promociones')->max('id'); if ($max) { DB::statement("SELECT setval('promociones_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('promocion_aplicaciones')->max('id'); if ($max) { DB::statement("SELECT setval('promocion_aplicaciones_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('proveedor')->max('id'); if ($max) { DB::statement("SELECT setval('proveedor_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('inventario_bruto')->max('id'); if ($max) { DB::statement("SELECT setval('inventario_bruto_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('inventario_procesado')->max('id'); if ($max) { DB::statement("SELECT setval('inventario_procesado_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('recetas')->max('id'); if ($max) { DB::statement("SELECT setval('recetas_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('caja')->max('id'); if ($max) { DB::statement("SELECT setval('caja_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('catering_servicios')->max('id'); if ($max) { DB::statement("SELECT setval('catering_servicios_id_seq', {$max})"); } } catch (\Exception $e) {}
            try { $max = DB::table('catering_servicio_detalles')->max('id'); if ($max) { DB::statement("SELECT setval('catering_servicio_detalles_id_seq', {$max})"); } } catch (\Exception $e) {}
        }
    }
}
