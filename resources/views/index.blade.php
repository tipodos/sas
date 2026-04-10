@extends('layouts/template')

@section('title', 'Terminal de Ventas - Plastiquería')

@section('content')
    <div class="container-fluid py-4" style="background-color: #f4f7f6; min-height: 90vh;">
        <div class="row g-4">

            <div class="col-lg-7">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 py-3 mt-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="fw-bold text-dark mb-0">📦 Catálogo de Productos</h4>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="search-box mb-4">
                            <div class="input-group input-group-lg shadow-sm"
                                style="border-radius: 12px; overflow: hidden;">
                                <span class="input-group-text bg-white border-0"><i
                                        class="fas fa-search text-muted"></i></span>
                                <input type="text" id="buscarProducto" class="form-control border-0 fs-5"
                                    placeholder="Buscar por nombre..." style="box-shadow: none;">
                            </div>
                        </div>

                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table align-middle">
                                <thead class="sticky-top bg-white" style="z-index: 10;">
                                    <tr class="text-muted small uppercase">
                                        <th class="border-0">DESCRIPCIÓN</th>
                                        <th class="border-0 text-center">PRECIO</th>
                                        <th class="border-0 text-center">CANT.</th>
                                        <th class="border-0 text-end">ACCION</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaProductos">
                                    @foreach ($productos as $p)
                                        <tr class="product-row">
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-shape bg-light rounded-3 me-3 d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="fas fa-box text-primary"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ $p->nombre }}</div>
                                                        <small class="text-muted">Stock: {{ $p->stock }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center fw-bold text-dark">S/ {{ number_format($p->precio, 2) }}
                                            </td>

                                            <td class="text-center" style="width: 100px;">
                                                <input type="number" id="qty_{{ $p->id }}"
                                                    class="form-control form-control-sm text-center shadow-sm"
                                                    value="1" min="1">
                                            </td>

                                            <td class="text-end">
                                                <button class="btn btn-primary btn-sm rounded-3 btn-agregar px-3"
                                                    data-id="{{ $p->id }}" data-nombre="{{ $p->nombre }}"
                                                    data-precio="{{ $p->precio }}" data-stock="{{ $p->stock }}">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-lg" style="border-radius: 20px; background: #fff;">
                    <div class="card-header bg-dark text-white py-4" style="border-radius: 20px 20px 0 0;">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-shopping-bag me-2"></i> Mi Carrito</h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="small text-muted fw-bold mb-2">NOMBRE</label>
                                <input type="text" id="nombreCliente" class="form-control border-0 bg-light rounded-3" placeholder="nombre del cliente">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted fw-bold mb-2">DNI</label>
                                <input type="text" id="dniCliente" class="form-control border-0 bg-light rounded-3" placeholder="DNI del cliente">
                            </div>
                            <div class="col-6">
                                <label class="small text-muted fw-bold mb-2">PAGO</label>
                                <select id="metodoPago" class="form-select border-0 bg-light rounded-3">
                                    <option value="efectivo">💵 Efectivo</option>
                                    <option value="yape">📱 Yape / Plin</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="small text-muted fw-bold mb-2">VENDEDOR</label>
                                <select id="personal_id" class="form-select border-0 bg-light rounded-3">
                                    @foreach ($personales as $p)
                                        <option value="{{ $p->id }}">
                                            {{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="carritoItems" class="mb-4"
                            style="min-height: 200px; max-height: 350px; overflow-y: auto;">
                        </div>

                        <div class="bg-light p-4 rounded-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="fw-black mb-0">TOTAL</h3>
                                <h2 class="fw-black text-primary mb-0">S/ <span id="totalVenta">0.00</span></h2>
                            </div>
                        </div>

                        <div class="d-grid gap-3">
                            <button class="btn btn-primary btn-lg py-3 fw-bold shadow ripple" id="btnFinalizar"
                                style="border-radius: 12px;">
                                <i class="fas fa-rocket me-2"></i> FINALIZAR Y COBRAR
                            </button>
                            <button class="btn btn-outline-danger btn-sm border-0" onclick="limpiarCarrito()">
                                <i class="fas fa-trash-alt me-1"></i> Vaciar Carrito
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let carrito = [];
        let total = 0;

        // Buscador
        document.getElementById('buscarProducto').addEventListener('input', function() {
            let filtro = this.value.toLowerCase();
            document.querySelectorAll('#tablaProductos tr').forEach(f => {
                f.style.display = f.innerText.toLowerCase().includes(filtro) ? '' : 'none';
            });
        });

        // Lógica de agregar mejorada con CANTIDAD
        document.addEventListener('click', function(e) {
            let btn = e.target.closest('.btn-agregar');
            if (btn) {
                let id = btn.dataset.id;
                let inputQty = document.getElementById('qty_' + id);
                let cantPedida = parseInt(inputQty.value) || 1;

                let p = {
                    id: id,
                    nombre: btn.dataset.nombre,
                    precio: parseFloat(btn.dataset.precio),
                    stock: parseInt(btn.dataset.stock)
                };

                agregarAlCarrito(p, cantPedida);
                inputQty.value = 1; // Resetear input a 1
            }
        });

        function agregarAlCarrito(p, cant) {
            let item = carrito.find(x => x.id === p.id);

            if (p.stock <= 0) return Swal.fire('Sin Stock', 'No hay productos', 'error');

            if (item) {
                if ((item.cantidad + cant) <= p.stock) {
                    item.cantidad += cant;
                } else {
                    return Swal.fire('Stock Insuficiente', 'Solo quedan ' + p.stock, 'warning');
                }
            } else {
                if (cant <= p.stock) {
                    carrito.push({
                        ...p,
                        cantidad: cant
                    });
                } else {
                    return Swal.fire('Stock Insuficiente', 'No puedes agregar ' + cant, 'warning');
                }
            }
            renderizar();
        }

        function renderizar() {
            const contenedor = document.getElementById('carritoItems');
            const totalSpan = document.getElementById('totalVenta');

            if (!contenedor) return;
            contenedor.innerHTML = '';
            total = 0;

            if (carrito.length === 0) {
                contenedor.innerHTML = '<p class="text-center mt-5 text-muted">Carrito vacío</p>';
                totalSpan.innerText = '0.00';
                return;
            }

            carrito.forEach((item, i) => {
                let sub = item.precio * item.cantidad;
                total += sub;

                contenedor.innerHTML += `
            <div class="item-carrito d-flex align-items-center justify-content-between border-bottom py-2">
                <div style="width: 50%">
                    <div class="fw-bold text-dark" style="font-size: 0.85rem;">${item.nombre}</div>
                    <small class="text-primary fw-bold">S/ ${item.precio.toFixed(2)}</small>
                </div>
                
                <div class="d-flex align-items-center justify-content-center" style="width: 30%">
                    <button class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="cambiarCantidad(${i}, -1)">-</button>
                    <span class="mx-2 fw-bold">${item.cantidad}</span>
                    <button class="btn btn-sm btn-outline-secondary px-2 py-0" onclick="cambiarCantidad(${i}, 1)">+</button>
                </div>

                <div class="text-end" style="width: 20%">
                    <div class="fw-bold text-dark">S/ ${sub.toFixed(2)}</div>
                    <button class="btn btn-sm text-danger p-0" onclick="quitar(${i})">
                        <i class="fas fa-trash-alt" style="font-size: 0.7rem;"></i>
                    </button>
                </div>
            </div>`;
            });
            totalSpan.innerText = total.toFixed(2);
        }

        // NUEVA FUNCIÓN PARA MODIFICAR DESDE EL CARRITO
        function cambiarCantidad(index, cambio) {
            let item = carrito[index];
            let nuevaCantidad = item.cantidad + cambio;

            if (nuevaCantidad <= 0) {
                quitar(index);
            } else if (nuevaCantidad > item.stock) {
                Swal.fire('Tope de Stock', 'Solo hay ' + item.stock + ' disponibles', 'warning');
            } else {
                item.cantidad = nuevaCantidad;
                renderizar();
            }
        }

        function quitar(i) {
            carrito.splice(i, 1);
            renderizar();
        }

        function quitar(i) {
            carrito.splice(i, 1);
            renderizar();
        }

        // Finalizar Venta
        document.getElementById('btnFinalizar').onclick = function() {
            const btn = this;
            const pId = document.getElementById('personal_id').value;
            const nomCli = document.getElementById('nombreCliente').value;
            const dniCli = document.getElementById('dniCliente').value;
            if (carrito.length === 0 || !pId) return Swal.fire('Error', 'Completa los datos', 'error');

            btn.disabled = true;
            btn.innerHTML = 'Procesando...';

            fetch("{{ route('ventas.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        productos: carrito,
                        personal_id: pId,
                        metodo_pago: document.getElementById('metodoPago').value,
                        total: total,
                        nombreCliente: nomCli, 
                        dniCliente: dniCli
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Venta Exitosa!',
                            text: '¿Desea imprimir el ticket de venta?',
                            icon: 'success',
                            showCancelButton: true, // Muestra el botón de cancelar
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '<i class="fas fa-print"></i> Imprimir Ticket',
                            cancelButtonText: 'Cerrar sin imprimir'
                        }).then((result) => {
                            // AQUÍ ESTÁ EL TRUCO: Solo si hace clic en el botón de Confirmar
                            if (result.isConfirmed) {
                                // Detecta si está en subcarpeta o en el puerto 8000 automáticamente
                                let url = `${window.location.origin}/plastiqueria/public/ventas/ticket/${data.venta_id}`;
    
                                window.open(url, '_blank');
                            }

                            // En ambos casos (si imprimió o no), recargamos para limpiar todo
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Ocurrió un error', 'error');
                        btn.disabled = false;
                        btn.innerHTML = 'FINALIZAR Y COBRAR';
                    }
                });
        };

        function limpiarCarrito() {
            if (confirm('¿Vaciar todo?')) {
                carrito = [];
                renderizar();
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const selectVendedor = document.getElementById('personal_id');

            // 1. Al cargar la página, vemos si hay un vendedor guardado
            const vendedorGuardado = localStorage.getItem('vendedor_fijo');
            if (vendedorGuardado) {
                selectVendedor.value = vendedorGuardado;
            }

            // 2. Cada vez que cambien el vendedor manualmente, lo guardamos
            selectVendedor.addEventListener('change', function() {
                localStorage.setItem('vendedor_fijo', this.value);
            });
        });
    </script>
@endpush
