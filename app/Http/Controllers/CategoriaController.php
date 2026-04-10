<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoriaController extends Controller
{

    public function index()
    {
        $categorias = Category::latest()->paginate(10);
        return view('categoria/categoria', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Category::create($request->all());
        return back()->with('success', 'Categoría creada!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categoria = Category::findOrFail($id);
        $categorias = Category::latest()->paginate(10);
        return view('categoria/editar', compact('categoria', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categoria = Category::findOrFail($id);
        $categoria->update($request->all());
        return redirect()->route('categoria.index')->with('success', 'Categoría actualizada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $categoria = Category::findOrFail($id);

        // Verificamos si tiene productos
        if ($categoria->products()->count() > 0) {
            return redirect()->back()->with('error_delete', '¡Operación Denegada! Esta categoría tiene ' . $categoria->products()->count() . ' productos asociados. Debes eliminarlos o cambiarlos de categoría primero.');
        }

        $categoria->delete();
        return redirect()->route('categoria.index')->with('success', 'Categoría eliminada correctamente.');
    }
}
