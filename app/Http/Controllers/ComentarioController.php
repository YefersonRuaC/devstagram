<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post) 
    {
        //Validar el formulario
        $this->validate($request, [
            'comentario' => ['required', 'max:255'],
        ]);
        
        //Almacenar los registros
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);
        
        //Imprimir un mensaje
        return back()->with('mensaje', 'Comentario realizado correctamente');
        //back nos manda a la pagina desde la que enviamos el formulario
        //en mensaje de with se imprime con un session() en le show.blade.php
    }
}
