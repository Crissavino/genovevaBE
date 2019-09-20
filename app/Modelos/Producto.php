<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'nuevo', 'popular', 'detalle', 'imagen1', 'imagen2', 'descuento', 'categoria_id', 'precio', 'visible'];
   
    use SoftDeletes;

    public function categoria()
    {
        return $this->belongsTo('App\Modelos\Categoria');
    }

    public function categoriassecundarias()
    {
        return $this->belongsToMany('App\Modelos\Categoriassecundaria');
    }

    public function colores()
    {
        return $this->belongsToMany('App\Modelos\Colore');
    }

    public function talles()
    {
        return $this->belongsToMany('App\Modelos\Talle');
    }

    public function stocks()
    {
        return $this->hasMany('App\Modelos\Stock');
        // return $this->belongsToMany('App\Modelos\Stock');
    }

    public function imagenesdetalles()
    {
        return $this->hasMany('App\Modelos\Imagenesdetalle');
    }

    public function imagenesshops()
    {
        return $this->hasMany('App\Modelos\Imagenesshop');
    }
}
