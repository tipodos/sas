<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    protected $fillable = [ 'total','customer_id', 'personal_id', 'metodo_pago','fecha'];

    public function personal()
    {
        return $this->belongsTo(personal::class, 'personal_id');
    }
    public function cliente()
    {
        return $this->belongsTo(customer::class, 'customer_id');
    }
    public function detalles() {
    return $this->hasMany(saleDatail::class, 'sale_id');
}
}

