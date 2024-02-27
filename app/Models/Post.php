<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //Esta es la informacion que se va llenar en la BD. Por eso los valores que se pasen aqui son los que van a 
    //crear el post en este caso
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    //Un post pertenece a un usuario
    public function user() //Esto es una relacion
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    //si el metodo no sigue los estandares de laravel. Por ej (user_id -> user()). Si lo hacemos por fuera de esos
    //estandares le debemos indicar como se llaman
    // public function usuario() 
    // {
    //     return $this->belongsTo(User::class, 'user_id')->select(['name', 'username']);
    // }

    public function comentarios() //Esto es una relaciond e muchos a muchos
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes() 
    {
        return $this->hasMany(Like::class);
    }

    //Verificar si un usuario ya dio like, para evitar duplicados
    public function checkLike(User $user) 
    {
        return $this->likes->contains('user_id', $user->id);
    }
}
