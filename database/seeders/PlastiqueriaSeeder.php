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
        DB::table('customers')->updateOrInsert(
            ['dni' => '00000000'],
            ['nombre' => 'Público General']
        );

        // 2. Categorías (Usamos updateOrInsert para evitar duplicados)
        DB::table('categories')->updateOrInsert(['nombre' => 'Bolsas de Polietileno']);
        DB::table('categories')->updateOrInsert(['nombre' => 'Envases Descartables']);

        // Obtenemos el ID de la categoría para los productos
        $catId = DB::table('categories')->where('nombre', 'Bolsas de Polietileno')->first()->id;

        // 3. Productos de prueba
        DB::table('products')->updateOrInsert(
            ['nombre' => 'Bolsa Negra 14x20 (Millar)'],
            ['precio' => 15.00, 'stock' => 100, 'category_id' => $catId]
        );

        DB::table('products')->updateOrInsert(
            ['nombre' => 'Film Stretch 20"'],
            ['precio' => 25.00, 'stock' => 20, 'category_id' => $catId]
        );

        // 4. Personal
        DB::table('personals')->updateOrInsert(
            ['dni' => '77777777'],
            ['name' => 'Luis Admin']
        );
    }
}
