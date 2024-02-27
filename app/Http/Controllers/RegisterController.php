<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() 
    {
        //vista que se va mostrar (render)
        return view('auth.register');
    }

    public function store(Request $request) 
    {   //Esta seria nuestra funcion de debuguear()
        // dd($request);

        //Modificando el request (no es muy recoendable hacerlo)
        $request->request->add(['username' => Str::slug($request->username)]);

        //Validacion en laravel
        $this->validate($request, [//Con el name="" del input, establecemos la validacion
            'name' => ['required', 'max:30'],//'users' es una tabla de nuestra BD, unique mostrara una alerta si
            'username' => ['required', 'unique:users', 'min:3', 'max:20'],//ese mismo username o email ya esta en la BD
            'email' => ['required', 'unique:users', 'email'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        //Creando un registro (INSERT)
        User::create([
            'name' => $request->name,
            //Debemos agregar este cmapo esperado en el modelo User.php
            //Str::lower: almacenara el texto que el usuario escriba, en minusculas
            //Str::slug: sustituye los espacios por guiones medios en la BD, para evitar problemas en nuestra BD
            // 'username' => Str::slug($request->username),
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password//Creo que ya no es necesario hashear el password manualmente, al
            // 'password' => Hash::make($request->password)//parecer laravel 10 ya lo tiene implementado automaticamente
        ]);

        //Autenticar el usuario
        // auth()->attempt([//Este attempt retorna un boolean, si el usuario se pudo o no autenticar
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]); 

        //Otra forma de autenticar el usuario
        auth()->attempt($request->only('email', 'password'));

        //Redireccionar a el usuario
        return redirect()->route('posts.index');
    }
}
