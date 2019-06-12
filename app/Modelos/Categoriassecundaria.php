<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoriassecundaria extends Model
{
    use SoftDeletes;

    public function productos()
    {
        return $this->belongsToMany('App\Modelos\Producto');
    }
}
