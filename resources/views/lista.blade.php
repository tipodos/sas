@extends('layouts.template')

@section('title', 'lista')
    
@section('content')
<div class="container">
    <h2>Filtrar Órdenes</h2>
    <form action="{{ route('lista.index') }}" method="GET" class="mb-4">
        <div class="form-group">
            <select name="filter" class="form-control">
                <option value="">Todas</option>
                <option value="today">Hoy</option>
                <option value="month">Este Mes</option>
                <option value="previous">Anteriores</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <a href="{{ route('orders.export') }}" class="btn btn-success mb-4">Descargar Excel</a>

    @if ($orders->isEmpty())
        <p>No se encontraron órdenes.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Celular</th>
                    <th>DNI</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->celular }}</td>
                        <td>{{ $order->dni }}</td>
                        <td>{{ $order->estadoTexto(); }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $order->total }}</td>
                        <td>
                            <a href="{{ route('show', $order->id) }}" class="btn btn-info btn-custom">Ver</a>
                            <form action="{{ route('delete', $order->id) }}" method="POST" style="display:inline-block; margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-custom" onclick="return confirm('¿Estás seguro de eliminar este registro?');">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="alert alert-info">
            <strong>Total de ganacia: </strong> {{ $total }}
        </div>
        <div class="alert alert-warning">
            <strong>Monto Pendiente de Cobrar: </strong> {{ $pending }}
        </div>

        <!-- Enlaces de paginación -->
        {{ $orders->links() }}
    @endif
</div>
@endsection