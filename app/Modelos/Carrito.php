<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $fillable = ['producto_id', 'user_id', 'cantidad', 'talle'];

    public function ordene()
    {
        return $this->belongsTo('App\Modelos\Ordenes');
    }
    
}
