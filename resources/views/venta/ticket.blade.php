<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante #{{ $venta->id }}</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Courier New', Courier, monospace; 
            width: 70mm; 
	    font-size: 12px;
	    font-family:monospace;
            margin: 0; 
	    margin-left: 20px;
            padding: 0; 
            color: #000;
            background-color: #fff;
        }
        
        /* Cabecera de Lujo */
        .header { text-align: center; margin-bottom: 20px; }
        .brand { 
            font-size: 12px; 
            font-weight: 900; 
            letter-spacing: 2px; 
            margin: 0;
            text-transform: uppercase;
            border-bottom: 2px solid #000;
            display: inline-block;
            padding-bottom: 5px;
        }
        .subtitle { font-size: 10px; margin-top: 5px; letter-spacing: 1px; }
        
        /* Info de Venta */
        .info { font-size: 11px; line-height: 1.4; margin-bottom: 15px; text-transform: uppercase; }
        
        /* Tabla de Productos */
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th { 
            font-size: 10px; 
            border-bottom: 1px solid #000; 
            padding: 5px 0; 
            text-align: left; 
        }
        td { font-size: 11px; padding: 8px 0; vertical-align: top; }
        .qty { width: 30px; }
        .price { text-align: right; width: 80px; }
        
        /* Totales Especiales */
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        .total-container { text-align: right; margin-top: 10px; }
        .total-label { font-size: 12px; font-weight: normal; }
        .total-amount { font-size: 18px; font-weight: 900; margin-top: 5px; }
        
        /* Pie de página */
        .footer { 
            text-align: center; 
            font-size: 10px; 
            margin-top: 30px; 
            line-height: 1.5;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .footer b { text-transform: uppercase; }

        /* Estilo para impresión */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
	    <h1 class="brand">INVERSIONES</h1>
        <h1 class="brand">NICAPLAS EIRL</h1>
        <div class="subtitle">CALIDAD & GARANTIA</div>
    </div>

    <div class="info">  
        <b>CLIENTE:</b> {{ $venta->cliente->nombre?:'CLIENTE ANONIMO' }}<br>
        <b>DNI:</b> {{ $venta->cliente->dni?:'00000000' }}<br>
        <br>
        <b>OPERACIÓN:</b> #{{ str_pad($venta->id, 6, '0', STR_PAD_LEFT) }}<br>
        <b>FECHA:</b> {{ $venta->created_at->format('d/m/Y H:i') }}<br>
        <b>PAGO:</b> {{ strtoupper($venta->metodo_pago ?? 'Efectivo') }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="qty">  CANT</th>
                <th>DESCRIPCIÓN.   </th>
		        <th style="text-align: right; padding-right: 5px;">PRECIO UNIT</th>
                <th class="price">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
            <tr>
                <td class="qty">{{ $detalle->cantidad }}</td>
                <td>{{ strtoupper($detalle->producto->nombre) }}</td>
		<td class="price">S/ {{number_format($detalle->precio_unitario, 2)}}</td>
                <td class="price">S/ {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="total-container">
        <div class="total-label">MONTO TOTAL RECIBIDO</div>
        <div class="total-amount">S/ {{ number_format($venta->total, 2) }}</div>
    </div>

    <div class="footer">
        <p>ATENDIDO POR: <b>{{ $venta->personal->name }}</b></p>
        <p>¡GRACIAS POR ELEGIRNOS!<br>Vuelva pronto.</p>
        <div style="margin-top: 10px; font-size: 8px;">*** COMPROBANTE SIN VALOR TRIBUTARIO ***</div>
    </div>

</body>
</html>