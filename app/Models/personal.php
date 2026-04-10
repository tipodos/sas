<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personal extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'dni'];
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function ventas()
    {
        return $this->hasMany(sale::class, 'personal_id');
    }
}
