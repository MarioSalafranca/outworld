<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImagenProducto extends Model
{
    use HasFactory;

    protected $table = 'imagenes_productos';
    protected $fillable = ['ruta', 'producto_id'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
