@extends('layouts.template')
@section('title', 'Registrar Compra')

@section('content')
    <div class="container py-4">
        <form action="{{ route('compras.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 text-primary"><i class="fas fa-cart-plus me-2"></i>Nueva Entrada de Mercadería
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small fw-bold">Proveedor</label>
                                    <select name="supplier_id" class="form-select select2" required>
                                        <option value="">Seleccionar proveedor...</option>
                                        @foreach ($proveedores as $p)
                                            <option value="{{ $p->id }}">{{ $p->nombre }} ({{ $p->ruc }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small fw-bold">Comprobante</label>
                                    <select name="comprobante" class="form-select">
                                        <option value="Boleta">Boleta</option>
                                        <option value="Factura">Factura</option>
                                        <option value="Guía">Guía de Remisión</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small fw-bold">N° de Comprobante</label>
                                    <input type="text" name="numero" class="form-control" placeholder="001-000123"
                                        required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label small fw-bold">Fecha</label>
                                    <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-end mb-4 bg-light p-3 rounded">
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold">Buscar Producto</label>
                                    <select id="pidproducto" class="form-select select2">
                                        <option value="">Escriba nombre del producto...</option>
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold">Cantidad</label>
                                    <input type="number" id="pcantidad" class="form-control" value="1" min="1">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small fw-bold">P. Compra Unitario</label>
                                    <input type="number" id="pprecio_compra" class="form-control" step="0.01"
                                        placeholder="0.00">
                                </div>
                                <div class="col-md-3">
                                    <button type="button" id="btn_agregar" class="btn btn-success w-100 shadow-sm">
                                        <i class="fas fa-plus me-1"></i> Añadir a la lista
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="tabla_detalle">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th width="80px">Quitar</th>
                                            <th>Producto</th>
                                            <th width="150px">Cantidad</th>
                                            <th width="150px">Precio Unit.</th>
                                            <th width="150px">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_detalle">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" class="text-end text-uppercase">Total de la Compra:</th>
                                            <th class="text-primary h5">
                                                S/ <span id="total_texto">0.00</span>
                                                <input type="hidden" name="total_compra" id="total_input_hidden">
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white text-end py-3">
                            <button type="submit" id="btn_guardar" class="btn btn-primary px-5 shadow"
                                style="display: none;">
                                <i class="fas fa-save me-1"></i> Confirmar y Guardar Compra
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let cont = 0;
        let total = 0;
        let subtotales = [];

        // Al hacer clic en agregar
        document.getElementById('btn_agregar').addEventListener('click', function() {
            agregarProducto();
        });

        function agregarProducto() {
            let id_producto = document.getElementById('pidproducto').value;
            let nombre_producto = document.getElementById('pidproducto').options[document.getElementById('pidproducto')
                .selectedIndex].text;
            let cantidad = parseFloat(document.getElementById('pcantidad').value);
            let precio = parseFloat(document.getElementById('pprecio_compra').value);

            if (id_producto != "" && cantidad > 0 && precio > 0) {

                let subtotal = cantidad * precio;
                subtotales[cont] = subtotal;
                total += subtotal;

                // Fila con inputs hidden con nombre[] para que Laravel los reciba como array
                let fila = `
    <tr id="fila${cont}">
        <td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarFila(${cont})"><i class="fas fa-trash"></i></button></td>
        <td>
            <input type="hidden" name="producto_id[]" value="${id_producto}"> 
            ${nombre_producto}
        </td>
        <td>
            <input type="hidden" name="cantidad[]" value="${cantidad}">
            ${cantidad}
        </td>
        <td>
            <input type="hidden" name="precio_costo[]" value="${precio}">
            S/ ${precio.toFixed(2)}
        </td>
        <td class="fw-bold">S/ ${subtotal.toFixed(2)}</td>
    </tr>
`;

                cont++;
                limpiarCampos();
                actualizarTotal();
                document.getElementById('tbody_detalle').innerHTML += fila;
                evaluarBotonGuardar();

            } else {
                alert("Por favor, complete los datos del producto, cantidad y precio.");
            }
        }

        function limpiarCampos() {
            document.getElementById('pcantidad').value = "1";
            document.getElementById('pprecio_compra').value = "";
        }

        function actualizarTotal() {
            document.getElementById('total_texto').innerHTML = total.toFixed(2);
            document.getElementById('total_input_hidden').value = total.toFixed(2);
        }

        function eliminarFila(index) {
            total -= subtotales[index];
            actualizarTotal();
            document.getElementById('fila' + index).remove();
            evaluarBotonGuardar();
        }

        function evaluarBotonGuardar() {
            if (total > 0) {
                document.getElementById('btn_guardar').style.display = 'inline-block';
            } else {
                document.getElementById('btn_guardar').style.display = 'none';
            }
        }
    </script>
@endsection
