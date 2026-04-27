<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\category;
use Illuminate\Http\Request;


class ProductoController extends Controller
{
    public function index()
    {

        $producto = product::where('visible', true)->latest()->paginate(10);
        $categorias = category::all();

        return view('products/index', compact('producto', 'categorias'));
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'stock'  => 'required|integer',
            'category_id' => 'required'
        ]);

        $producto = new product();
        $producto->nombre = $request->input('nombre');
        $producto->precio = $request->input('precio');
        $producto->stock = $request->input('stock');
        $producto->category_id = $request->input('category_id');
        $producto->save();

        return redirect()->route('producto.index')->with('success', 'Producto creado exitosamente.');
    }
    public function edit($id)
    {

        $producto = product::findOrFail($id);
        $categorias = category::all();
        $productos = product::latest()->paginate(10);

        return view('products/edit', compact('producto', 'productos', 'categorias'));
    }
    public function update(Request $request, $id)
    {
        $producto = Product::findOrFail($id);
        $producto->nombre = $request->input('nombre');
        $producto->precio = $request->input('precio');
        $producto->stock = $request->input('stock');
        $producto->save();

        return redirect()->route('producto.index')->with('success', 'Producto actualizado exitosamente.');
    }
    Public function show($id)
    {
        //
    }
    public function delete(Request $request)
    {
        try {
            $producto = product::find($request->id);
            $producto->delete();
            return redirect()->route('producto.index')->with('success', 'Producto eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // El código 23000 es cuando tiene ventas amarradas (llaves foráneas)
            if ($e->getCode() == "23000") {
                return redirect()->route('producto.index')->with('error', 'No se puede eliminar: Este producto ya tiene ventas registradas. Mejor cámbiale el nombre o ponle stock 0.');
            }

            // Por si pasa cualquier otra cosa rara
            return redirect()->route('producto.index')->with('error', 'No se pudo eliminar el producto.');
        }
    }
    public function estado($id)
    {
        $producto = product::findOrFail($id);
        $producto->visible = !$producto->visible; // Cambia el estado al opuesto
        $producto->save();

        return redirect()->route('producto.index')->with('success', 'Estado del producto actualizado exitosamente.');
    }
    public function desactivados()
    {
        $productos = product::where('visible', false)->latest()->paginate(10);
        return view('products/desactivado', compact('productos'));
    }
}
