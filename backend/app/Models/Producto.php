<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'marca',
        'categoria_id',
        'acabado_id',
        'codigo_color_hex',
        'nombre_color',
        'precio',
        'stock',
        'disponible',
        'imagen_url',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'disponible' => 'boolean',
    ];

    // Relación: un producto pertenece a una categoría
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación: un producto pertenece a un acabado
    public function acabado(): BelongsTo
    {
        return $this->belongsTo(Acabado::class);
    }

    // Scope para buscar por color hexadecimal exacto
    public function scopePorColorHex($query, string $hex)
    {
        return $query->where('codigo_color_hex', $hex);
    }

    // Scope para productos disponibles
    public function scopeDisponibles($query)
    {
        return $query->where('disponible', true)->where('stock', '>', 0);
    }
}