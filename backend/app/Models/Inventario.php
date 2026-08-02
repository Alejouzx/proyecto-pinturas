<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    // Conexión con la tabla de inventario en PostgreSQL
    protected $table = 'inventario';

    protected $fillable = [
        'producto_id',
        'stock_actual',
        'stock_minimo'
    ];

    // Desactivamos el updated_at automático de Laravel ya que manejamos timestamps personalizados
    const UPDATED_AT = null;

    /**
     * Relación inversa: El inventario pertenece a un único producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}