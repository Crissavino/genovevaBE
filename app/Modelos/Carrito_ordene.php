<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrito_ordene extends Model
{
    use SoftDeletes;
    protected $fillable = ['carrito_id', 'ordene_id'];
}
