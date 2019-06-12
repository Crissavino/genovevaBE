<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Imagenesdetalle extends Model
{
    protected $fillable = ['path'];
    
    use SoftDeletes;

    public function productos()
    {
        return $this->hasMany('App\Modelos\Producto');
    }
}
