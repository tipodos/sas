@extends('layouts.template')
@section('title', 'Proveedores Ocultos')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-secondary">
                <i class="fas fa-eye-slash me-2"></i>Productos Desactivados
            </h2>
            <p class="text-muted small mb-0">Lista de productos que estan desactivados</p>
        </div>
        <a href="{{ route('producto.index') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver a Activos
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-4 py-3">Producto</th>
                            <th>Categoría</th>
                            <th>Precio de Compra</th>
                            <th>Precio de Venta</th>
                            <th>Precio por mayor</th>
                            <th>Stock</th>
                            <th class="text-center">Restaurar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $p)
                            <tr class="opacity-75">
                                <td class="fw-bold text-dark">{{ $p->nombre }}</td>
                                <td>{{ $p->categoria->nombre ?? 'Sin categoría' }}</td>
                                <td class="text-success fw-bold">S/ {{ number_format($p->costo, 2) }}</td>
                                <td class="text-primary fw-bold">S/ {{ number_format($p->precio, 2) }}</td>
                                <td class="text-info fw-bold">S/ {{ number_format($p->precio_mayoreo, 2) }}</td>
                                <td>{{ $p->stock }}</td>
                                <td class="text-center">
                                    <form action="{{ route('producto.estado', $p->id) }}" method="POST" class="d-inline">
                                        @csrf @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3 shadow-sm">
                                            <i class="fas fa-user-check me-1"></i> Activar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-3x text-light mb-3"></i>
                                    <p class="text-muted">No hay productos desactivados actualmente.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection