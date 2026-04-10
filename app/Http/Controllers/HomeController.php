<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\sale;
use App\Models\product;
use App\Models\category;
use App\Models\personal;
use App\Models\saleDatail;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $fecha = $request->input('fecha', date('Y-m-d'));
        $f_inicio = $request->input('f_inicio', date('Y-m-d'));
        $f_fin = $request->input('f_fin', date('Y-m-d'));

        $fechaDinamica = \Carbon\Carbon::parse($fecha);
        $fechaInicio = \Carbon\Carbon::parse($fecha)->subDays(7);

        $totalVentasHoy = sale::whereBetween('created_at', [$f_inicio . ' 00:00:00', $f_fin . ' 23:59:59'])->sum('total');
        $ventasYape = sale::whereBetween('created_at', [$f_inicio . ' 00:00:00', $f_fin . ' 23:59:59'])
            ->where('metodo_pago', 'yape')->sum('total');
        $ventasEfectivo = sale::whereDate('created_at', $fecha)->where('metodo_pago', 'efectivo')->sum('total');

        // 2. Resumen del Mes
        $totalVentasMes = sale::whereMonth('created_at', $fechaDinamica->month)
            ->whereYear('created_at', $fechaDinamica->year)
            ->sum('total');

        // 3. Stock Crítico (Menos de 6 unidades)
        $productosCriticos = product::where('stock', '>=', 0)->where('stock', '<=', 5)->take(10)->orderBy('stock', 'asc')->get();
        $conteoCriticos = $productosCriticos->count();

        // 4. Top 5 Productos más vendidos (Histórico)
        $topProductos = saleDatail::select('product_id', DB::raw('SUM(cantidad) as total_vendido'))
            ->groupBy('product_id')
            ->orderByDesc('total_vendido')
            ->take(10)
            ->with('producto')
            ->get();

        // 5. NUEVO: Últimas 10 ventas para la lista de lujo
        $ventasRecientes = sale::with('personal')
            ->whereBetween('created_at', [$f_inicio . ' 00:00:00', $f_fin . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();
        $hoy = date('Y-m-d');
        $haceSieteDias = date('Y-m-d', strtotime('-7 days'));

        $ventasSemanales = sale::selectRaw('DATE(created_at) as fecha, SUM(total) as total')
            ->whereBetween('created_at', [$haceSieteDias . ' 00:00:00', $hoy . ' 23:59:59'])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $ventasMensualesRaw = sale::selectRaw('MONTH(created_at) as mes_num, SUM(total) as total')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mes_num')
            ->orderBy('mes_num', 'asc')
            ->get();

        $mesesEspañol = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];
        $ventasMensuales = $ventasMensualesRaw->map(function ($item) use ($mesesEspañol) {
            return [
                'mes' => $mesesEspañol[$item->mes_num],
                'total' => $item->total
            ];
        });

        // Gráfico de Métodos de Pago: Para saber de dónde viene la plata
        $metodosPago = sale::selectRaw('metodo_pago, SUM(total) as total')
            ->whereBetween('created_at', [$f_inicio . ' 00:00:00', $f_fin . ' 23:59:59'])
            ->groupBy('metodo_pago')
            ->get();

        return view('show', compact(
            'fecha',
            'f_inicio',
            'f_fin',
            'totalVentasHoy',
            'ventasYape',
            'ventasEfectivo',
            'totalVentasMes',
            'productosCriticos',
            'conteoCriticos',
            'topProductos',
            'ventasRecientes',
            'ventasMensuales',
            'metodosPago',
            'ventasSemanales' // <--- No te olvides de pasar esta
        ));
    }
    public function exportarExcel(Request $request)
    {
        // 1. Limpiar cualquier espacio o error previo que rompa el archivo
        if (ob_get_length()) ob_end_clean();

        $inicio = $request->input('f_inicio', date('Y-m-d'));
        $fin = $request->input('f_fin', date('Y-m-d'));

        // Asegúrate de que en tu modelo 'Sale' la relación se llame 'detalles'
        $ventas = sale::with(['personal', 'cliente', 'detalles'])
            ->whereBetween('created_at', [$inicio . ' 00:00:00', $fin . ' 23:59:59'])
            ->get();

        $filename = "Reporte_Ventas_" . $inicio . "_al_" . $fin . ".xls";

        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Para que Excel entienda las tildes y la 'ñ' de Perú
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

        echo "<table border='1'>";
        echo "<tr><th colspan='7' style='background-color: #d9edf7; font-size: 16px;'>REPORTE DE VENTAS DETALLADO ($inicio al $fin)</th></tr>";
        echo "<tr style='background-color: #f2f2f2;'>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Vendedor</th>
            <th>Cliente</th>
            <th>Items</th>
            <th>Metodo</th>
            <th>Total</th>
          </tr>";

        foreach ($ventas as $v) {
            // 1. Limpiamos el nombre del cliente (Evita el JSON feo)
            $clienteNombre = 'Público General';
            if ($v->cliente) {
                // Si es un objeto/relación, sacamos el nombre. Si es texto, lo usamos directo.
                $clienteNombre = is_object($v->cliente) ? ($v->cliente->nombre ?? 'Público General') : $v->cliente;
            }

            // 2. Color de fila para Yape (Celeste bajito para que resalte)
            $fondo = (strtolower($v->metodo_pago) == 'yape') ? 'style="background-color: #e3f2fd;"' : '';

            echo "<tr $fondo>";
            echo "<td>" . $v->created_at->format('d/m/Y') . "</td>";
            echo "<td>" . $v->created_at->format('h:i A') . "</td>";
            echo "<td>" . ($v->personal->nombre ?? $v->personal->name ?? 'N/A') . "</td>";
            echo "<td>" . $clienteNombre . "</td>"; // <--- Nombre limpio

            // Usamos 'detalles' que es como lo cargaste en el 'with'
            $cantItems = $v->detalles ? $v->detalles->sum('cantidad') : 0;
            echo "<td align='center'>" . $cantItems . "</td>";

            echo "<td>" . strtoupper($v->metodo_pago) . "</td>";
            echo "<td><b>S/ " . number_format($v->total, 2) . "</b></td>";
            echo "</tr>";
        }

        $totalRango = $ventas->sum('total');
        echo "<tr><td colspan='6' align='right'><b>TOTAL DEL PERIODO:</b></td><td><b>S/ " . number_format($totalRango, 2) . "</b></td></tr>";
        echo "</table>";
        exit;
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
