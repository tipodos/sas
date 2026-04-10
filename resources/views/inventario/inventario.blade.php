@extends('layouts.template')

@section('title', 'Inventario')

@section('content')
    <div class="container py-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body bg-light">
                <div class="row align-items-center">
                    <div class="col-lg-4 mb-3 mb-lg-0">
                        <h2 class="h4 mb-0 text-gray-800">
                            <i class="fas fa-boxes text-primary me-2"></i>Gestión de Stock
                        </h2>
                    </div>

                    <div class="col-lg-4 mb-3 mb-lg-0">
                        <form action="{{ route('lista.index') }}" method="GET">
                            <div class="input-group border rounded bg-white shadow-sm">
                                <input type="text" name="search" class="form-control border-0 shadow-none"
                                    placeholder="Nombre o Categoría..." value="{{ request('search') }}">
                                <button class="btn btn-white text-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4 text-lg-end">
                        <div class="btn-group shadow-sm" role="group">
                            <a href="{{ route('lista.index', ['filter' => 'all']) }}"
                                class="btn btn-sm btn-light border {{ request('filter') == 'all' || !request('filter') ? 'active bg-secondary text-white' : '' }}">
                                Todos
                            </a>
                            <a href="{{ route('lista.index', ['filter' => 'bajo']) }}"
                                class="btn btn-sm btn-light border {{ request('filter') == 'bajo' ? 'active bg-warning' : '' }}">
                                ⚠️ Bajo
                            </a>
                            <a href="{{ route('lista.index', ['filter' => 'agotado']) }}"
                                class="btn btn-sm btn-light border {{ request('filter') == 'agotado' ? 'active bg-danger text-white' : '' }}">
                                🚫 Agotado
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="ps-4">Producto</th>
                            <th>Categoría</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Estado</th>
                            <th class="text-end pe-4">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $p)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">{{ $p->nombre }}</td>
                                <td>
                                    <span class="badge bg-light text-muted border py-1 px-2">
                                        {{ $p->category->nombre ?? 'Sin categoría' }}
                                    </span>
                                </td>
                                <td class="text-center fw-bold">{{ $p->stock }} <small>uds</small></td>
                                <td class="text-center">
                                    @if ($p->stock <= 0)
                                        <span class="badge bg-danger rounded-pill">Agotado</span>
                                    @elseif($p->stock <= 10)
                                        <span class="badge bg-warning text-dark rounded-pill">Bajo Stock</span>
                                    @else
                                        <span class="badge bg-success rounded-pill">Disponible</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4 fw-bold text-primary">
                                    S/ {{ number_format($p->precio, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-search fa-3x mb-3 opacity-25"></i><br>
                                    No hay productos con esos filtros.
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
@endsection
