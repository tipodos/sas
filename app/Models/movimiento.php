<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class movimiento extends Model
{
    protected $fillable = ['product_id', 'tipo', 'cantidad', 'precio_costo', 'descripcion'];
    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
