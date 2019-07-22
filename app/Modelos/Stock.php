<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    protected $fillable = ['producto_id', 'talle_id', 'cantidad'];

    use SoftDeletes;

    public function producto()
    {
        // return $this->belongsToMany('App\Modelos\Producto');
        return $this->belongsTo('App\Modelos\Producto');
    }

    public function talle()
    {
        return $this->belongsTo('App\Modelos\Talle');
    }

}
