<?php

namespace App\Http\Controllers;

use App\Models\movimiento;
use App\Models\product;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movimientos = movimiento::with('product')->get();
        $productos = product::where('visible', 1)->get();
        return view('movimientos.movimiento', compact('movimientos', 'productos'));
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
    $p = Product::findOrFail($request->product_id);
    
    if ($request->tipo == 'Salida' && $p->stock < $request->cantidad) {
        return back()->with('error', 'No hay stock suficiente para esta salida.');
    }

    // 1. Crear el registro del movimiento
    $mov = new Movimiento();
    $mov->product_id = $request->product_id;
    $mov->tipo = $request->motivo;
    $mov->cantidad = $request->cantidad;
    $mov->precio_costo = 0; // "Rotura", "Traslado", etc.
    $mov->descripcion = $request->descripcion;
    $mov->save();

    // 2. Actualizar el stock del producto
    if ($request->tipo == 'Entrada') {
        $p->increment('stock', $request->cantidad);
    } else {
        $p->decrement('stock', $request->cantidad);
    }

    return redirect()->back()->with('success', 'Movimiento registrado y stock actualizado.');
}

    /**
     * Display the specified resource.
     */
    public function show(movimiento $movimiento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(movimiento $movimiento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, movimiento $movimiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(movimiento $movimiento)
    {
        //
    }
}
