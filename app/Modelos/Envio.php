<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Envio extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'ordene_id', 'name', 'lastname', 'pais_id', 'calle', 'numero', 'cp', 'provincia', 'ciudad', 'telefono', 'email'];

    public function ordene()
    {
        return $this->belongsTo('App\Modelos\Ordenes');
    }
}
