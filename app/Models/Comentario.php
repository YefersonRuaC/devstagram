<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'comentario'
    ];

    //Por medio de una relacion, trayendo el usuario que escribio el comentarip
    public function user() 
    {//Relacion uno a uno
        return $this->belongsTo(User::class);
    }
}
