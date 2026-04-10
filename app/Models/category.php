<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $fillable = ['nombre'];
    public function products()
    {
        // Esto le dice a Laravel que 'category_id' en la tabla 'products' se conecta con esta tabla 'categories'
        return $this->hasMany(product::class, 'category_id');
    }
}
