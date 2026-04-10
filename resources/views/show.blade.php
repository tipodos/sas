@extends('layouts.template')
@section('title', 'Detalles de Venta')
@section('content')
    <style>
        .card-luxury {
            border-radius: 20px;
            transition: transform 0.3s;
        }

        .card-luxury:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .text-xs-luxury {
            font-size: 0.75rem;
            letter-spacing: 1px;
            opacity: 0.8;
        }

        .progress-luxury {
            height: 8px;
            border-radius: 10px;
            background: #eaecf4;
        }

        /* Estilos para la tabla de ventas */
        .table-luxury thead {
            background-color: #f8f9fc;
        }

        .table-luxury th {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #aab2bd;
            border: none;
        }

        .table-luxury td {
            vertical-align: middle;
            border-top: 1px solid #f1f3f9;
            padding: 15px 10px;
        }

        .badge-yape {
            background-color: #742784;
            color: white;
        }

        /* Color morado Yape */
    </style>

    <div class="container-fluid py-4" style="background: #f8f9fc; min-height: 100vh;">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h1 class="h3 mb-1 text-dark fw-bold">Análisis de Negocio</h1>
                <p class="text-muted small mb-0">Bienvenido, Angelo. Aquí está el pulso de tu empresa hoy.</p>
            </div>
            <div class="text-end">
                <span class="badge bg-white text-dark shadow-sm px-3 py-2 border-0" style="border-radius: 10px;">
                    <i class="far fa-calendar-alt me-2 text-primary"></i> {{ date('d M, Y') }}
                </span>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-6 mb-4">
                <div class="card border-0 shadow-sm card-luxury">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="m-0 fw-bold text-dark"><i class="fas fa-chart-line text-primary me-2"></i>Rendimiento de
                            Ventas (Últimos 7 días)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="graficoVentas" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-6 mb-4">
                <div class="card card-luxury shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold"><i class="fas fa-chart-bar me-2 text-primary"></i>Comparativa Mensual (6 meses)
                        </h6>
                        <canvas id="chartMensual" style="max-height: 325px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('graficoVentas').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($ventasSemanales->pluck('fecha')) !!},
                    datasets: [{
                        label: 'Ventas S/',
                        data: {!! json_encode($ventasSemanales->pluck('total')) !!},
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4 // Esto hace que la línea sea curva (smooth)
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        </script>
        <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 shadow-sm"
            style="border-radius: 15px;">
            <div>
                <h4 class="m-0 fw-bold text-dark">Panel de Control</h4>
                <small class="text-muted" id="statusText">Viendo ingresos en tiempo real</small>
            </div>

            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="modoHistorial"
                    style="width: 50px; height: 25px; cursor: pointer;">
                <label class="form-check-label fw-bold ms-2" for="modoHistorial">Modo Historial</label>
            </div>
        </div>

        <div id="wrapperCalendario" style="display: none;" class="card mb-4 p-3 shadow-sm border-0"
            style="border-radius: 15px;">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="small fw-bold text-muted">Desde:</label>
                    <input type="date" id="fechaInicio" class="form-control" value="{{ $f_inicio }}">
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold text-muted">Hasta:</label>
                    <input type="date" id="fechaFin" class="form-control" value="{{ $f_fin }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" onclick="filtrarRango()">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="col-md-2">
                    <button type="button" onclick="exportarExcelYa()" class="btn btn-success w-100">
                        <i class="fas fa-file-excel"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card cuadro card-luxury border-0 shadow-sm text-white h-100"
                    style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-xs-luxury text-uppercase mb-1 fw-bold">Ventas de Hoy</div>
                                <h2 class="mb-0 fw-bold">S/ {{ number_format($totalVentasHoy, 2) }}</h2>
                            </div>
                            <div class="icon-box"><i class="fas fa-shopping-cart fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card cuadro card-luxury border-0 shadow-sm text-white h-100"
                    style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-xs-luxury text-uppercase mb-1 fw-bold">Ventas del Mes</div>
                                <h2 class="mb-0 fw-bold">S/ {{ number_format($totalVentasMes, 2) }}</h2>
                            </div>
                            <div class="icon-box"><i class="fas fa-calendar-check fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card cuadro card-luxury border-0 shadow-sm text-white h-100"
                    style="background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-xs-luxury text-uppercase mb-1 fw-bold">Recaudo Digital</div>
                                <h2 class="mb-0 fw-bold">S/ {{ number_format($ventasYape, 2) }}</h2>
                            </div>
                            <div class="icon-box"><i class="fas fa-mobile-alt fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-luxury border-0 shadow-sm text-white h-100"
                    style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-xs-luxury text-uppercase mb-1 fw-bold">Stock Crítico</div>
                                <h2 class="mb-0 fw-bold">{{ $conteoCriticos }} <small
                                        style="font-size: 1rem">Alertas</small></h2>
                            </div>
                            <div class="icon-box"><i class="fas fa-box-open fa-lg"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm card-luxury h-100">
                    <div class="card-header bg-white py-3 border-0 mt-2">
                        <h5 class="m-0 fw-bold text-dark"><i class="fas fa-crown text-warning me-2"></i>Los más vendidos
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach ($topProductos as $tp)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <span class="fw-bold text-dark d-block">{{ $tp->producto->nombre }}</span>
                                        <small class="text-muted">Movimiento: {{ $tp->total_vendido }} unidades</small>
                                    </div>
                                    <span class="badge bg-soft-primary text-primary px-3 py-1"
                                        style="background: #eef4ff;">Top #{{ $loop->iteration }}</span>
                                </div>
                                <div class="progress progress-luxury">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ ($tp->total_vendido / $topProductos->first()->total_vendido) * 100 }}%; border-radius: 10px;">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-sm card-luxury h-100">
                    <div class="card-header bg-white py-3 border-0 mt-2">
                        <h5 class="m-0 fw-bold text-danger"><i class="fas fa-truck-loading me-2"></i>Reponer Inventario
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush px-2">
                            @forelse($productosCriticos as $pc)
                                <div class="list-group-item d-flex justify-content-between align-items-center border-0 mb-2 p-3"
                                    style="background: #fff5f5; border-radius: 12px;">
                                    <div>
                                        <span class="d-block fw-bold text-danger">{{ $pc->nombre }}</span>
                                        <small class="text-muted">Stock actual disponible</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-danger px-3 py-2"
                                            style="border-radius: 8px;">{{ $pc->stock }} uni.</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3 opacity-25"></i>
                                    <p class="text-muted">Todo el inventario está bajo control.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm card-luxury">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold text-dark"><i class="fas fa-list-ul text-primary me-2"></i>Ventas Recientes
                        </h5>
                        <span class="text-muted small">Últimos movimientos del día</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-luxury mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Ticket</th>
                                        <th>Hora</th>
                                        <th>Cajero</th>
                                        <th>Método Pago</th>
                                        <th class="text-end">Total</th>
                                        <th class="text-center pe-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ventasRecientes as $v)
                                        <tr>
                                            <td class="ps-4 fw-bold text-primary">
                                                #{{ str_pad($v->id, 5, '0', STR_PAD_LEFT) }}</td>
                                            <td class="text-muted">{{ $v->created_at->format('H:i A') }}</td>
                                            <td>
                                                <span class="small fw-bold">{{ $v->personal->name ?? 'Sistema' }}</span>
                                            </td>
                                            <td>
                                                @if (strtolower($v->metodo_pago) == 'yape')
                                                    <span class="badge badge-yape rounded-pill px-3">Yape</span>
                                                @else
                                                    <span
                                                        class="badge bg-light text-dark border rounded-pill px-3">Efectivo</span>
                                                @endif
                                            </td>
                                            <td class="text-end fw-bold">S/ {{ number_format($v->total, 2) }}</td>
                                            <td class="text-center pe-4">
                                                <button onclick="reimprimirTicket({{ $v->id }})"
                                                    class="btn btn-sm btn-dark rounded-pill px-3 shadow-sm"
                                                    style="font-size: 0.7rem;">
                                                    <i class="fas fa-print me-1"></i> TICKET
                                                </button>
                                                <form action="{{ route('ventas.anular', $v->id) }}" method="POST"
                                                    onsubmit="return confirm('¿Seguro que quieres ANULAR esta venta? El stock regresará al inventario.')"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm rounded-pill px-3">
                                                        <i class="fas fa-ban"></i> Anular
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5">No hay ventas hoy.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggle = document.getElementById('modoHistorial');
            const calendario = document.getElementById('wrapperCalendario');
            const statusText = document.getElementById('statusText');
            const tarjetas = document.querySelectorAll('.cuadro');

            // 1. BLINDAJE: Detectar si estamos en modo historial por URL
            const urlParams = new URLSearchParams(window.location.search);
            const enHistorial = urlParams.has('f_inicio') || urlParams.has('f_fin');

            if (enHistorial) {
                toggle.checked = true;
                calendario.style.display = 'block';
                statusText.innerText = "Consultando rango: " + urlParams.get('f_inicio') + " al " + urlParams.get(
                    'f_fin');
                statusText.classList.replace('text-muted', 'text-danger');
                tarjetas.forEach(t => t.style.filter = "grayscale(60%) brightness(80%)");
            }

            toggle.addEventListener('change', function() {
                if (this.checked) {
                    calendario.style.display = 'block';
                    statusText.innerText = "Seleccione fechas para filtrar";
                    statusText.classList.replace('text-muted', 'text-danger');
                } else {
                    // Si apaga el switch, regresamos al "Hoy" limpio
                    window.location.href = "{{ route('home.index') }}";
                }
            });
        });

        // 2. BLINDAJE EXCEL: Evitar descargas vacías
        function exportarExcelYa() {
            const inicio = document.getElementById('fechaInicio').value;
            const fin = document.getElementById('fechaFin').value;

            if (!inicio || !fin) {
                return Swal.fire('Error', 'Selecciona el rango de fechas primero, mano.', 'warning');
            }

            // Bloqueamos el botón un segundo para que no le den mil clics
            const btn = event.currentTarget;
            btn.disabled = true;

            const url = `{{ route('ventas.exportar') }}?f_inicio=${inicio}&f_fin=${fin}`;
            window.location.href = url;

            setTimeout(() => btn.disabled = false, 3000);
        }

        // 3. FUNCIÓN PARA FILTRAR (La Lupa)
        function filtrarRango() {
            let inicio = document.getElementById('fechaInicio').value;
            let fin = document.getElementById('fechaFin').value;

            // Comodidad: Si solo pone inicio, asumimos que quiere ver ese mismo día
            if (inicio && !fin) {
                fin = inicio;
            }

            if (inicio && fin) {
                // Redirigimos con los dos parámetros que Laravel ahora espera
                window.location.href = `{{ route('home.index') }}?f_inicio=${inicio}&f_fin=${fin}`;
            } else {
                alert("Mano, selecciona al menos la fecha de inicio.");
            }
        }

        // Cuando cambie la fecha en el calendario


        // Cuando cambie la fecha en el calendario


        function reimprimirTicket(ventaId) {
            // Definimos el tamaño de la ventanita (ancho de ticketera)
            const ancho = 400;
            const alto = 600;
            const x = (screen.width / 2) - (ancho / 2);
            const y = (screen.height / 2) - (alto / 2);

            // Abrimos la ruta que ya tienes creada para el ticket
            // Asegúrate de que esta ruta sea la misma que usas en tu controlador
            window.open(
                '/plastiqueria/public/ventas/ticket/' + ventaId,
                'Ticket de Venta',
                `width=${ancho},height=${alto},left=${x},top=${y},toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes`
            );
        }
        const ctxMes = document.getElementById('chartMensual').getContext('2d');
        new Chart(ctxMes, {
            type: 'bar',
            data: {
                // Usamos map para extraer los nombres de los meses y los totales
                labels: {!! json_encode($ventasMensuales->pluck('mes')) !!},
                datasets: [{
                    label: 'Total por Mes S/',
                    data: {!! json_encode($ventasMensuales->pluck('total')) !!},
                    backgroundColor: '#1cc88a',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
