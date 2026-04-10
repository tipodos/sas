<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    protected $fillable = ['nombre', 'dni'];

    public function ventas()
    {
        return $this->hasMany(sale::class, 'customer_id');
    }
}

