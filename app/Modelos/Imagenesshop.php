<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagenesshop extends Model
{
    protected $fillable = ['path', 'producto_id'];

    use SoftDeletes;

    public function productos()
    {
        return $this->belongsTo('App\Modelos\Producto');
    }
}
