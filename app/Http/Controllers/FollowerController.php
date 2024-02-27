<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    //Almacenar cuando un usuario sigue a otro
    public function store(User $user) //auth()->user()->id es el usuario autenticado
    {//Este $user es el perfil que estamos visitando (al que podemos darle en seguir)
        $user->followers()->attach( auth()->user()->id );
        //attach es como un create (pero al no seguir las convenciones laravel) lo usamos para que no haya errores
        return back();
    }

    public function destroy(User $user)
    {
        $user->followers()->detach( auth()->user()->id );

        return back();
    }
}
