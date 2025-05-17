<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaDrink extends Model
{
    use HasFactory;

    protected $fillable = ['tipo', 'nombre'];

    public function scopeTipoCoctel($query)
    {
        return $query->where('tipo', 'tipo_coctel');
    }

    public function scopeBaseSabor($query)
    {
        return $query->where('tipo', 'base_sabor');
    }

    public function scopeTiempoPreparacion($query)
    {
        return $query->where('tipo', 'tiempo_preparacion');
    }
}
