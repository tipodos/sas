<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\sale;

class saleDatail extends Model
{
    protected $fillable = ['sale_id', 'product_id', 'cantidad', 'precio_unitario'];
    public function sale()
    {
        return $this->belongsTo(sale::class, 'sale_id');
    }
    public function producto()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
