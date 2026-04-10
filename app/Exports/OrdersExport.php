<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\orderDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('orderDetails')->get();
    }

    public function headings(): array
    {
        return [
            'Numero de orden',
            'Nombre',
            'Celular',
            'DNI',
            'Fecha de Creación',
            'Estado',
            'Adelanto',
            'Total',
            'fecha por defecto'
        ];
    }
    public function map($order): array
    {
        // Combina los detalles del pedido en un solo string
        

        return [
            $order->name,
            $order->celular,
            $order->dni,
            $order->order_date,
            $order->estadoTexto(),
            $order->total,
            $order->adelanto,
        ];
    }
}
