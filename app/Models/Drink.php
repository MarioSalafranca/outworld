<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
        'texto',
        'pasos',
        'producto_id',
        'tipo_coctel_id',
        'base_sabor_id',
        'tiempo_preparacion_id',
    ];


    public function ingredientesPivot()
    {
        return $this->belongsToMany(Ingrediente::class, 'drink_ingrediente', 'drink_id', 'ingrediente_id'
        )->withPivot('cantidad');
    }

    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'drink_ingrediente', 'drink_id', 'ingrediente_id'
        )->withPivot('cantidad');
    }


    public function instrumentos()
    {
        return $this->belongsToMany(Instrumento::class, 'drink_instrumento', 'drink_id', 'instrumento_id');
    }

    public function productos()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function reseñas()
    {
        return $this->hasMany(Reseña::class);
    }

    public function imagenes()
    {
        return $this->hasMany(DrinkImagen::class);
    }

    public function tipoCoctel()
    {
        return $this->belongsTo(CategoriaDrink::class, 'tipo_coctel_id');
    }

    public function baseSabor()
    {
        return $this->belongsTo(CategoriaDrink::class, 'base_sabor_id');
    }

    public function tiempoPreparacion()
    {
        return $this->belongsTo(CategoriaDrink::class, 'tiempo_preparacion_id');
    }


}
