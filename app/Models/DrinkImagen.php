<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrinkImagen extends Model
{
    use HasFactory;

    protected $table = 'drinks_imagenes';

    protected $fillable = ['ruta', 'drink_id'];

    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }
}
