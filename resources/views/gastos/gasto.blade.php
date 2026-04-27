@extends('layouts.template')
@section('title', 'Control de Gastos')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-money-bill-wave me-2"></i>Registrar Nuevo Gasto</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('gastos.store')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Motivo / Categoría</label>
                            <select name="motivo" class="form-select" required>
                                <option value="Alquiler">Alquiler</option>
                                <option value="Luz/Agua">Luz o Agua</option>
                                <option value="Personal">Pago a Personal</option>
                                <option value="Transporte">Transporte / Flete</option>
                                <option value="Limpieza">Limpieza</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Descripción Detallada</label>
                            <textarea name="descripcion" class="form-control" rows="2" placeholder="Ej: Pago de luz mes de Abril" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Monto (S/)</label>
                                <input type="number" name="monto" class="form-control" step="0.01" placeholder="0.00" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Fecha</label>
                                <input type="date" name="fecha_gasto" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 shadow">
                            <i class="fas fa-save me-1"></i> Guardar Gasto
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="text-secondary">Gastos Recientes</h5>
                    <hr>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Motivo</th>
                                    <th>Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gastos as $g)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($g->fecha_gasto)->format('d/m/Y') }}</td>
                                        <td>{{ $g->motivo }}</td>
                                        <td class="text-danger fw-bold">S/ {{ number_format($g->monto, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection