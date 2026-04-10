<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'categoria', 'order_date', 'estado', 'total'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function estadoTexto()
    {
        switch ($this->estado) {
            case 0:
                return 'Pendiente';
            case 1:
                return 'Completado';
            // Otros casos si los hay...
            default:
                return 'Desconocido';
        }
    }
    public function getStatusTextAttribute()
    {
        return $estados[$this->getAttribute('estado')] ?? 'Desconocido';
    }
}
