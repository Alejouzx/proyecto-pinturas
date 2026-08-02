<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acabado extends Model
{
    protected $table = 'acabados';
    protected $fillable = ['nombre', 'descripcion'];
}