<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    /** @use HasFactory<\Database\Factories\ProductoFactory> */
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'texto',
        'precio',
        'imagen',
        'stock',
    ];

    public function compras()
    {
        return $this->belongsToMany(Compra::class, 'compra_producto')
            ->withPivot('cantidad', 'precio_unitario')
            ->withTimestamps();
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto')
            ->withTimestamps();
    }

    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class);
    }

    public function atributos()
    {
        return $this->hasOne(AtributosProductos::class);
    }

    public function ingredientes()
    {
        return $this->hasMany(IngredienteProducto::class);
    }

}
