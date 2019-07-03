<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrito extends Model
{
    use SoftDeletes;
    protected $fillable = ['id', 'producto_id', 'user_id', 'ordene_id', 'cantidad', 'talle', 'talle_id'];

    public function ordene()
    {
        return $this->belongsTo('App\Modelos\Ordenes');
    }
    
}
