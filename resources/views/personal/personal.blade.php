@extends('layouts.template')

@section('title', 'Personal')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0 text-gray-800">
            <i class="fas fa-users text-success me-2"></i>Gestión de Personal
        </h2>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-success">Registrar Trabajador</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('personal.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-uppercase fw-bold text-muted">Nombre Completo</label>
                            <input type="text" name="name" class="form-control" placeholder="Ej: Angelo Admin" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-uppercase fw-bold text-muted">DNI</label>
                            <input type="text" name="dni" class="form-control" placeholder="8 dígitos" maxlength="8" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 shadow-sm">
                            <i class="fas fa-user-plus me-1"></i> Guardar Personal
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
                                <th class="ps-4 border-0">DNI</th>
                                <th class="border-0">Nombre</th>
                                <th class="text-center border-0">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personales as $p)
                            <tr>
                                <td class="ps-4">{{ $p->dni }}</td>
                                <td class="fw-bold">{{ $p->name }}</td>
                                <td class="text-center">
                                    <form action="{{ route('personal.delete', $p->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm text-danger border-0"><i class="fas fa-trash"></i></button>
                                    </form>
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