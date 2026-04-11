<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PlastiqueriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // 1. Cliente Genérico (Solo lo inserta si el DNI no existe)
        DB::table('datos')->updateOrInsert(
            ['nombre_empresa' => 'Mi Plastiquería'],
            ['ruc_empresa' => '12345678901', 'direccion_empresa' => 'Av. Principal 123', 'telefono' => '987654321', 'correo' => 'info@miplastiqueria.com', 'moneda'=>'S/']
        );

        DB::table('customers')->updateOrInsert(
            ['dni' => '00000000'],
            ['nombre' => 'Público General']
        );

        DB::table('suppliers')->updateOrInsert(
            ['ruc' => '00000000000'],
            ['nombre' => 'Proveedor Genérico', 'telefono'=>'987654321', 'direccion'=>'Sin Dirección', 'estado'=>1]
        );
        // 2. Categorías (Usamos updateOrInsert para evitar duplicados)
        DB::table('categories')->updateOrInsert(['nombre' => 'Bolsas de Polietileno']);
        DB::table('categories')->updateOrInsert(['nombre' => 'Envases Descartables']);

        // Obtenemos el ID de la categoría para los productos
        $catId = DB::table('categories')->where('nombre', 'Bolsas de Polietileno')->first()->id;
        $catId2 = DB::table('categories')->where('nombre', 'Envases Descartables')->first()->id;

        // 3. Productos de prueba
        DB::table('products')->updateOrInsert(
            ['nombre' => 'Bolsa Negra 14x20 (Millar)'],
            ['costo'=>13.00,'precio' => 15.00,'precio_mayoreo' =>14.00 ,'stock' => 100, 'category_id' => $catId, 'visible'=>1]
        );

        DB::table('products')->updateOrInsert(
            ['nombre' => 'Film Stretch 20"'],
            ['costo'=>20.00,'precio' => 25.00,'precio_mayoreo' =>23.00 ,'stock' => 20, 'category_id' => $catId2, 'visible'=>1]
        );

        // 4. Personal
        DB::table('personals')->updateOrInsert(
            ['dni' => '77777777'],
            ['name' => 'Luis Admin']
        );
    }
}
