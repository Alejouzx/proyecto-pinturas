<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    // Conexión con la tabla de pedidos en PostgreSQL
    protected $table = 'pedidos';

    // Campos que permitimos registrar masivamente en una compra
    protected $fillable = [
        'codigo_seguimiento',
        'cliente_nombre',
        'cliente_email',
        'cliente_telefono',
        'total',
        'estado',
        'notas',
    ];
}