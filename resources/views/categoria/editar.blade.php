@extends('layouts.template')

@section('title', 'Categorías')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0 text-gray-800">
                <i class="fas fa-tags text-primary me-2"></i>Editar Categoria: {{ $categoria->nombre }}
            </h2>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Editar Categoría</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('categoria.update', $categoria->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label small text-uppercase fw-bold text-muted">Nombre</label>
                                <input type="text" name="nombre" class="form-control form-control-user"
                                    placeholder="Ej: Bolsas de Polietileno" value="{{ $categoria->nombre }}" required>
                            </div>
                            <button type="submit"
                                class="btn {{ isset($categoria) ? 'btn-warning' : 'btn-primary' }} w-100 shadow-sm">
                                <i class="fas {{ isset($categoria) ? 'fa-sync-alt' : 'fa-save' }} me-1"></i>
                                {{ isset($categoria) ? 'ACTUALIZAR CATEGORÍA' : 'GUARDAR CATEGORÍA' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Listado de Categorías</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 border-0">ID</th>
                                        <th class="border-0">Nombre de Categoría</th>
                                        <th class="text-center border-0">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categorias as $cat)
                                        <tr>
                                            <td class="ps-4 text-muted small">#{{ $cat->id }}</td>
                                            <td>
                                                <span class="fw-bold text-dark">{{ $cat->nombre }}</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group shadow-sm">
                                                    <a href="{{ route('categoria.edit', $cat->id) }}"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('categoria.delete', $cat->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('¿Eliminar esta categoría?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">
                                                No hay categorías registradas aún.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3 d-flex justify-content-center">
                                {{ $categorias->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if (session('error_delete'))
        <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 1060;">
            <div class="alert alert-white shadow-lg border-start border-danger border-5 p-4" role="alert"
                style="max-width: 400px; background: white;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle text-danger fa-3x me-3"></i>
                    <div>
                        <h5 class="alert-heading fw-bold text-danger">¡Atención, Angelo!</h5>
                        <p class="mb-0 text-dark">{{ session('error_delete') }}</p>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('categoria.index') }}" class="btn btn-danger btn-sm px-4 fw-bold">
                        Entendido
                    </a>
                </div>
            </div>
        </div>
        <div
            style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); z-index: 1050;">
        </div>
    @endif
@endsection
