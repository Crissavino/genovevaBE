<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Talle extends Model
{
    use SoftDeletes;

    public function productos()
    {
        return $this->belongsToMany('App\Modelos\Producto');
    }

    public function stocks()
    {
        return $this->hasMany('App\Modelos\Stock');
    }
    
}
