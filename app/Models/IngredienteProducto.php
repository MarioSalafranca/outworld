<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IngredienteProducto extends Model
{
    use HasFactory;

    protected $table = 'ingredientes_productos';

    protected $fillable = ['producto_id', 'nombre'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
