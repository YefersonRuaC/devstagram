<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Si un controlador solo tiene un metodo (index) podemos crear este tipo de metodo (invoke) para que se mande
    //automaticamente, pero tambien debemos modificar nuestro routing en web.php
    public function __invoke()
    {
        //Obtener a quienes seguimos. pluck() trae los campos que le especifiquemos
        $ids = auth()->user()->follows->pluck('id')->toArray();
        //Usamos whereIn porque los posts de los usuarios que sigue, van ser un arreglo
        //where (solo), solamente revisa un valor (como un id en particular)
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(4);

        return view('home', [
            'posts' => $posts
        ]);
    }
}
