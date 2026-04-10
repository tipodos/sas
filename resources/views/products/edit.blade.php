@extends('layouts.template')

@section('title', 'Productos')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Editar Producto: {{ $producto->nombre }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('producto.update', $producto->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-bold text-secondary">Nombre del Producto</label>
                                <input type="text" name="nombre" class="form-control form-control-lg shadow-none"
                                    placeholder="Ej: Bolsa Negra 14x20" required style="border-radius: 10px;"
                                    value="{{ $producto->nombre }}">
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-bold text-secondary">Precio (S/)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">S/</span>
                                        <input type="number" name="precio" class="form-control shadow-none border-start-0"
                                            step="0.01" placeholder="0.00" required value="{{ $producto->precio }}">
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label fw-bold text-secondary">Stock Inicial</label>
                                    <input type="number" name="stock" class="form-control shadow-none" placeholder="0"
                                        required value="{{ $producto->stock }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-secondary">Categoría</label>
                                <select name="category_id" class="form-select shadow-none" required>
                                    <option value="{{ $producto->category_id }}">{{ $producto->category->nombre }}</option>
                                    @foreach ($categorias as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit"
                                class="btn {{ isset($producto) ? 'btn-warning' : 'btn-primary' }} w-100 shadow-sm">
                                <i class="fas {{ isset($producto) ? 'fa-sync-alt' : 'fa-save' }} me-1"></i>
                                {{ isset($producto) ? 'ACTUALIZAR PRODUCTO' : 'GUARDAR EN INVENTARIO' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-dark fw-bold"><i
                                class="fas fa-boxes me-2 text-primary"></i>Inventario Actual</h5>
                        <span class="badge bg-soft-primary text-primary px-3 py-2" style="background-color: #e7f1ff;">
                            {{ $productos->count() }} Productos Registrados
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-secondary">
                                    <tr>
                                        <th class="ps-4 py-3">Producto</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($productos as $item)
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark">{{ $item->nombre }}</td>
                                            <td>
                                                <span class="badge rounded-pill bg-light text-dark border">
                                                    {{ $item->category->nombre ?? 'Sin categoría' }}
                                                </span>
                                            </td>
                                            <td class="text-success fw-bold">S/ {{ number_format($item->precio, 2) }}</td>
                                            <td>
                                                @if ($item->stock <= 5)
                                                    <span class="badge bg-danger p-2 w-75">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        {{ $item->stock }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-success p-2 w-75">
                                                        {{ $item->stock }} unidades
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group shadow-sm">
                                                    <a href="{{ route('producto.edit', $item->id) }}"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('producto.delete', $item->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('¿Eliminar este producto?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                                Aún no hay productos en el inventario.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3 d-flex justify-content-center">
                                {{ $productos->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
