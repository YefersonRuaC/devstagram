<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    //Recordemos que aqui pasamos lo que se va llenar en el modelo de Follower
    protected $fillable = [
        'user_id',
        'follower_id'
    ];
}
