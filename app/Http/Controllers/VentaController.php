<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\product;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\customer;
use App\Models\personal;
use App\Models\sale;
use App\Models\saleDatail;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Sale::all();
        $productos = product::all();
        $categorias = Category::all();
        $personales = Personal::all();
        return view('index', compact('ventas', 'productos', 'categorias', 'personales'));
    }

    public function export()
    {
        // Aquí puedes implementar la lógica para exportar las ventas a Excel o CSV
        // Por ejemplo, podrías usar una biblioteca como Maatwebsite/Laravel-Excel
        // para generar un archivo Excel con los datos de las ventas.
    }
    public function store(Request $request)
    {
        // 1. Validación
        $request->validate([
            'productos'    => 'required|array',
            'personal_id'  => 'required',
            'total'        => 'required',
            'metodo_pago'  => 'required',
            'nombreCliente'=> 'nullable|string|max:255',
            'dniCliente'   => 'nullable|string|max:8'
        ]);

        try {
            return DB::transaction(function () use ($request) {

                // 2. Crear la Venta Principal
                // Forzamos que guarde el total y metodo_pago
                $cliente = customer::firstOrCreate(
                    ['dni'=>$request->dniCliente],
                    ['nombre'=>$request->nombreCliente]
                );

                $venta = sale::create([
                    'customer_id' => $cliente->id,
                    'personal_id' => $request->personal_id,
                    'total'       => $request->total,
                    'metodo_pago' => $request->metodo_pago,
                ]);

                // 3. Crear el Detalle
                foreach ($request->productos as $item) {
                    saleDatail::create([
                        'sale_id'        => $venta->id,
                        'product_id'     => $item['id'],
                        'cantidad'        => $item['cantidad'],
                        'precio_unitario' => $item['precio'],
                    ]);

                    // 4. Descontar Stock
                    $producto = product::find($item['id']);
                    if ($producto) {
                        $producto->decrement('stock', $item['cantidad']);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Venta registrada con éxito',
                    'venta_id' => $venta->id
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error crítico: ' . $e->getMessage()
            ], 500);
        }
    }
    public function generarTicket($id)
    {
        // Buscamos la venta con sus detalles y productos
        // Asegúrate de tener las relaciones configuradas en el Modelo
        $venta = sale::with(['detalles.producto', 'personal'])->findOrFail($id);
        $cliente = customer::find($venta->customer_id);

        return view('venta/ticket', compact('venta', 'cliente'));
    }
    public function anular($id)
    {
        // 1. Buscamos la venta
        $venta = Sale::findOrFail($id);

        // 2. Buscamos los productos de esa venta (detalles)
        $detalles = SaleDatail::where('sale_id', $id)->get();

        // 3. Regresamos el stock uno por uno
        foreach ($detalles as $item) {
            $producto = Product::find($item->product_id);
            if ($producto) {
                $producto->increment('stock', $item->cantidad);
            }
        }

        // 4. Borramos los detalles y la venta
        SaleDatail::where('sale_id', $id)->delete();
        $venta->delete();

        return back()->with('success', 'Venta anulada. El stock ha sido restaurado.');
    }
}
