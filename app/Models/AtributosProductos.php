<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtributosProductos extends Model
{
    protected $fillable = [
        'sabor', 'tamanio', 'porcentaje_alcohol', 'metodo_destilacion', 'color'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
