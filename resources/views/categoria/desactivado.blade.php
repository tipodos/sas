@extends('layouts.template')
@section('title', 'Proveedores Ocultos')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0 text-secondary">
                <i class="fas fa-eye-slash me-2"></i>Categorías Desactivadas
            </h2>
            <p class="text-muted small mb-0">Lista de categorías que estan desactivadas</p>
        </div>
        <a href="{{ route('categoria.index') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver a Activas
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-4 py-3">Categoría</th>
                            <th class="text-center">Restaurar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categorias as $c)
                            <tr class="opacity-75">
                                <td class="fw-bold text-dark">{{ $c->nombre }}</td>
                                <td class="text-center">
                                    <form action="{{ route('categoria.estado', $c->id) }}" method="POST" class="d-inline">
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
                                    <p class="text-muted">No hay categorías desactivadas actualmente.</p>
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