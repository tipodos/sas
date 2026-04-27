<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = supplier::where('estado', 1)->get();
        return view('proveedor.proveedor', compact('proveedores'));
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
        $request->validate([
            'ruc' => 'required|unique:suppliers,ruc',
            'nombre' => 'required',
            'telefono' => 'max:9|nullable',
            'direccion' => 'max:255|nullable'
        ]);

        $proveedor = new supplier();
        $proveedor->ruc = $request->ruc;
        $proveedor->nombre= $request->nombre;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->save();

        return redirect()->route('proveedor.index')->with('success', ' proveedor registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $proveedor = supplier::findOrFail($id);
        $proveedores = supplier::where('estado', 1)->get();
        return view('proveedor/editar', compact('proveedor','proveedores'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ruc'=> 'required|unique:suppliers,ruc,'.$id,
            'nombre' => 'required',
            'telefono' => 'max:9|nullable',
            'direccion' => 'max:255|nullable'
        ]);

        $proveedor = supplier::findorfail($id);
        $proveedor->ruc = $request->ruc;
        $proveedor->nombre = $request->nombre;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->save();

        return redirect()->route('proveedor.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(supplier $supplier)
    {
        //
    }
    public function estado($id)
    {
        $p = supplier::findOrFail($id);
        $p->estado = !$p->estado;
        $p->save();
        return redirect()->route('proveedor.index');
    }
    public function inactivos()
{
    // Solo traemos los que el dueño ocultó
    $proveedores = supplier::where('estado', 0)->get();
    return view('proveedor.desactivado', compact('proveedores'));
}
}
