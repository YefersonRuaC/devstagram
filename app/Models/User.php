<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    //AQUI VAN LOS DATOS QUE ESPERAMOS QUE EL USUARIO ENVIE POR EL FORMULARIO
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    //CON ESTE ARRAY, YA NO ES NECESARIO HASHEAR EL PASSWORD, LARAVEL LO HACE AUTOMATICAMENTE
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //Un usuario puede tener multiples posts
    public function posts()
    {
        //Relacion de uno a muchos (One to many)
        return $this->hasMany(Post::class);//Creamos la relacion de la clase User y Post
    }

    public function likes() 
    {
        return $this->hasMany(Like::class);
    }

    //Metodo que almacena los seguidores de un usario
    public function followers()
    {
        //El metodo followers(), en la tabla de followers, pertenece a muchos usuarios (users belongsTo Many)
        //Y pasamos las foreign key que relaciona las tablas (user_id) y (follower_id). Para que, gracias al metodo
        //followers() pueda insertar en la tabla de followers tanto el (user_id) como (follower_id)
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    //Metodo que almacena a los usuarios que seguimos
    public function follows()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    //Comprobar si un usuario ya sigue a otro
    public function siguiendo(User $user)
    {
        //Accede al etodo "followers" (de arriba) y va revisar si ese usaurio es seguidor de esa persona
        return $this->followers->contains($user->id);
    }
}
