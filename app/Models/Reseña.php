<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseña extends Model
{
    use HasFactory;

    protected $fillable = ['drink_id', 'usuario', 'comentario', 'valoracion', 'parent_id'];

    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }

    public function respuestas()
    {
        return $this->hasMany(Reseña::class, 'parent_id')->with('respuestas');
    }

    public function padre()
    {
        return $this->belongsTo(Reseña::class, 'parent_id');
    }
}
