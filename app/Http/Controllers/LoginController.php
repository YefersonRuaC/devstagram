<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() 
    {
        return view('auth.login');
    }

    public function store(Request $request) {

        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
    
        //Si el usuario no esta auth, mostraremos el mensaje
        if(!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            //back() indica que se retorne a la pagina anterior (es decir, que no lo deje avanzar)
            //with indica el mensaje y el contenido de este mensaje que se puede consumir desde las views
            return back()->with('mensaje', 'Credenciales incorrectas');
        }

        //Como en el web.php, posts,index requiere el nombre del usuario para poder mostrarlo en la url
        //debemos pasar ese username para que lo pase hacia posts.index y no haya error
        return redirect()->route('posts.index', [auth()->user()->username]);
    }
}
