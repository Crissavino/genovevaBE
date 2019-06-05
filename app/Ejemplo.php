<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Ejemplo extends Model
{
    protected $fillable = ['title', 'description', 'user_id'];

}
