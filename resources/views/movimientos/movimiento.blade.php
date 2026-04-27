@extends('layouts.template')
@section('title', 'Movimientos de Stock')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Nuevo Movimiento</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('movimientos.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Producto</label>
                            <select name="product_id" class="form-select select2" required>
                                <option value="">Seleccionar producto...</option>
                                @foreach($productos as $p)
                                    <option value="{{ $p->id }}">
                                        {{ $p->nombre }} (Stock: {{ $p->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Tipo de Movimiento</label>
                            <div class="d-flex gap-2">
                                <input type="radio" class="btn-check" name="tipo" id="entrada" value="Entrada" checked>
                                <label class="btn btn-outline-success w-50" for="entrada"><i class="fas fa-plus-circle"></i> Entrada</label>

                                <input type="radio" class="btn-check" name="tipo" id="salida" value="Salida">
                                <label class="btn btn-outline-danger w-50" for="salida"><i class="fas fa-minus-circle"></i> Salida</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Motivo</label>
                            <select name="motivo" class="form-select" required>
                                <option value="Merma/Rotura">Merma / Rotura</option>
                                <option value="Traslado">Traslado entre locales</option>
                                <option value="Ajuste de Inventario">Ajuste de Inventario</option>
                                <option value="Donación/Muestra">Donación o Muestra</option>
                                <option value="Otro">Otro motivo</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Cantidad</label>
                            <input type="number" name="cantidad" class="form-control" min="1" placeholder="0" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Observación (Opcional)</label>
                            <textarea name="descripcion" class="form-control" rows="2" placeholder="Ej: Se rompió al bajar del camión"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 shadow-sm">
                            <i class="fas fa-check-circle me-1"></i> Registrar Movimiento
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-secondary fw-bold">Historial Reciente de Movimientos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Producto</th>
                                    <th>Tipo</th>
                                    <th>Motivo</th>
                                    <th>Cant.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movimientos as $m)
                                <tr>
                                    <td class="small">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="fw-bold">{{ $m->product->nombre }}</td>
                                    <td>
                                        @if($m->tipo == 'Entrada')
                                            <span class="badge bg-success-soft text-success"><i class="fas fa-arrow-up"></i> Entrada</span>
                                        @else
                                            <span class="badge bg-danger-soft text-danger"><i class="fas fa-arrow-down"></i> Salida</span>
                                        @endif
                                    </td>
                                    <td><small class="text-muted">{{ $m->tipo }}</small></td>
                                    <td class="fw-bold">{{ $m->cantidad }}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Un toque de color suave para los badges */
    .bg-success-soft { background-color: #e8fadf; }
    .bg-danger-soft { background-color: #fceaea; }
</style>
<script>
    $(document).ready(function() {
        // 1. Inicializar Select2 para buscar productos rápido
        $('.select2').select2({
            placeholder: "Escriba el nombre del producto...",
            allowClear: true,
            width: '100%'
        });

        // 2. Validación de Stock en tiempo real (Opcional pero pro)
        const form = document.querySelector('form');
        const selectProducto = document.querySelector('select[name="product_id"]');
        const inputCantidad = document.querySelector('input[name="cantidad"]');
        const radioSalida = document.getElementById('salida');

        form.addEventListener('submit', function(e) {
            // Solo validamos si el movimiento es una SALIDA
            if (radioSalida.checked) {
                // Obtenemos el stock actual desde el texto de la opción seleccionada
                let optionText = selectProducto.options[selectProducto.selectedIndex].text;
                let stockMatch = optionText.match(/Stock: (\d+)/);
                let stockActual = stockMatch ? parseInt(stockMatch[1]) : 0;
                let cantidadSalida = parseInt(inputCantidad.value);

                if (cantidadSalida > stockActual) {
                    e.preventDefault(); // Detiene el envío del formulario
                    alert('¡Mano, cuidado! No puedes sacar ' + cantidadSalida + ' unidades porque solo tienes ' + stockActual + ' en stock.');
                }
            }
        });
    });
</script>
@endsection