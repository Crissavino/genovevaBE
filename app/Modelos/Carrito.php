<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrito extends Model
{
    use SoftDeletes;
    protected $fillable = ['producto_id', 'user_id', 'cantidad', 'talle'];

    public function ordene()
    {
        return $this->belongsTo('App\Modelos\Ordenes');
    }
    
}
