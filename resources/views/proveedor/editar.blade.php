@extends('layouts.template')
@section('title', 'proveedor')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0 text-gray-800">
            <i class="fas fa-users text-success me-2"></i>Gestión de Proveedores
        </h2>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-success">Editar Proveedor {{ $proveedor->nombre}}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('proveedor.update', $proveedor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small text-uppercase flex-bold text-muted">RUC</label>
                            <input type="text" name="ruc" class="form-control" placeholder="Ej: 20123456789" value="{{ $proveedor->ruc}}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-uppercase fw-bold text-muted">Nombre Completo</label>
                            <input type="text" name="name" class="form-control" placeholder="Ej: Empresa S.A." value="{{$proveedor->nombre}}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-uppercase fw-bold text-muted">Telefono</label>
                            <input type="text" name="telefono" class="form-control" placeholder="Ej: 987654321" maxlength="9" value="{{$proveedor->telefono}}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-uppercase fw-bold text-muted">Dirección</label>
                            <input type="text" name="direccion" class="form-control" placeholder="Ej: Av. Principal 123" value="{{$proveedor->direccion}}">
                        </div>
                        <button type="submit" class="btn btn-success w-100 shadow-sm">
                            <i class="fas fa-user-plus me-1"></i> Editar Proveedor
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 border-0">RUC</th>
                                <th class="border-0">Nombre</th>
                                <th class="border-0">Teléfono</th>
                                <th class="border-0">Dirección</th>
                                <th class="text-center border-0">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proveedores as $p)
                            <tr>
                                <td class="ps-4">{{ $p->ruc }}</td>
                                <td class="fw-bold">{{ $p->nombre }}</td>
                                <td>{{ $p->telefono }}</td>
                                <td>{{ $p->direccion }}</td>
                                <td class="text-center">
                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection