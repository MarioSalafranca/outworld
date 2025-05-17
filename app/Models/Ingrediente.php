<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion'];

    public function drinks()
    {
        return $this->belongsToMany(Drink::class, 'drink_ingrediente')
            ->withPivot('cantidad')
            ->withTimestamps();
    }
}
