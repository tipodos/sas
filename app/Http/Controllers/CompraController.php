<?php

namespace App\Http\Controllers;

use App\Models\compra;
use Illuminate\Support\Facades\DB;
use App\Models\detalle_compra;
use App\Models\supplier;
use App\Models\product;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = compra::all();
        $proveedores = supplier::where('estado', 1)->get();
        $productos = product::all();
        return view('compras.compra', compact('compras', 'proveedores', 'productos'));
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
    DB::beginTransaction();
    try {
        $compra = new Compra();
        $compra->supplier_id = $request->supplier_id;
        $compra->comprobante = $request->comprobante;
        // Aquí corregimos los nombres según tu HTML
        $compra->numero_comprobante = $request->numero; // En el HTML pusiste name="numero"
        $compra->total = $request->total_compra;      // En el HTML pusiste name="total_compra"
        $compra->save();

        // Estos nombres ahora coinciden con el JS de arriba
        $productos = $request->producto_id; 
        $cantidades = $request->cantidad;
        $precios = $request->precio_costo;

        if ($compra && is_array($productos)) {
            for ($i = 0; $i < count($productos); $i++) {
                $detalleCompra = new detalle_compra();
                $detalleCompra->compra_id = $compra->id;
                $detalleCompra->product_id = $productos[$i];
                $detalleCompra->cantidad = $cantidades[$i];
                $detalleCompra->precio_costo = $precios[$i];
                $detalleCompra->save();

                $p = product::findOrFail($productos[$i]);
                $p->stock += $cantidades[$i];
                $p->costo = $precios[$i];
                $p->save();
            }
        }

        DB::commit();
        return redirect()->route('compra.index')->with('success', '¡Ya está en la DB, mano!');
    } catch (\Exception $e) {
        DB::rollback();
        // Este return te va a decir exactamente qué falló si vuelve a pasar
        return back()->with('error', 'Falló algo: ' . $e->getMessage());
    }
}

    /**
     * Display the specified resource.
     */
    public function show(compra $compra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(compra $compra)
    {
        //
    }
}
