<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ordene extends Model
{
    use SoftDeletes;
    protected $fillable = ['numOrden', 'user_id'];

    public function carritos()
    {
        return $this->hasMany('App\Modelos\Carrito');
    }
    
}
