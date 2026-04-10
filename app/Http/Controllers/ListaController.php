<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ListaController extends Controller
{
       public function index(Request $request)
{
    // 1. Capturamos lo que viene de la URL
    $search = $request->get('search');
    $filter = $request->get('filter');

    // 2. Empezamos la consulta
    $query = Product::with('category');

    // 3. Si hay búsqueda por nombre o categoría
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('nombre', 'LIKE', "%$search%")
              ->orWhereHas('category', function($cat) use ($search) {
                  $cat->where('nombre', 'LIKE', "%$search%");
              });
        });
    }

    // 4. AQUÍ ESTÁ EL TRUCO: Filtros de botones
    if ($filter == 'bajo') {
        $query->where('stock', '<=', 10)->where('stock', '>', 0);
    } elseif ($filter == 'agotado') {
        $query->where('stock', '<=','0');
    }

    // 5. Ordenamos (el más nuevo arriba) y paginamos
    $productos = $query->latest()->paginate(15);

    // 6. Retornamos a la vista
    return view('inventario.inventario', compact('productos'));
}
}
