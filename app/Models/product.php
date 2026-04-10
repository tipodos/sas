<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'precio', 'stock', 'category_id'];
    public function category()
    {
        // Esto le dice a Laravel que 'category_id' se conecta con la tabla 'categories'
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function detalles() {
        return $this->hasMany(saleDatail::class, 'product_id');
    }
}
