<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'usuarios';
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'usuario_user';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'usuario_user',
        'email',
        'nombre',
        'apellido',
        'password',
        'telefono',
        'calle',
        'ciudad',
        'cp',
        'numero',
        'pais',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function compras()
    {
        return $this->hasMany(Compra::class, 'usuario_user', 'usuario_user');
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'usuario_user', 'usuario_user');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'usuario_user', 'usuario_user');
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class, 'usuario_user', 'usuario_user');
    }

    public function reseñas()
    {
        return $this->hasMany(Resena::class, 'usuario_user', 'usuario_user');
    }

    public static function checkUsuario($data){
        $usuario = $data['usuario'];
        $password = $data['password'];

        $user = self::where('usuario_user', $usuario)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        } else {
            return null;
        }
    }



}
