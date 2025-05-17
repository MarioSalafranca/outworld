<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';

    protected $fillable = [
        'fecha',
        'total',
        'envio',
        'email',
        'telefono',
        'calle',
        'ciudad',
        'cp',
        'numero',
        'pais',
        'usuario_user',
    ];

    // Relación con Productos (muchos a muchos con datos extra)
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'compras_producto')
            ->withPivot('cantidad', 'precio_unitario')
            ->withTimestamps();
    }
}
