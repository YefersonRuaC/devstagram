<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    //Proteger la ruta para evitar que un usuario no autenticado entre a editar el perfil escribiendo la ruta en la url
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        return view('perfil.index');
    }

    public function store(Request $request) //a un metodo store siempre le pasamos el Request $request
    {
        //Modificando el request (no es muy recoendable hacerlo)
        $request->request->add(['username' => Str::slug($request->username)]);

        $this->validate($request, [
            //Creando un "lista negra" de usernames que no se pueden usar
            'username' => ['required', 'unique:users,username,'.auth()->user()->id, 'min:3', 'max:20', 
            'not_in:twitter,editar-perfil'],
            'email' => ['required', 'unique:users,email,'.auth()->user()->id]

            //Tambein podemos crear una "lista blanca" de usernames que se pueden usar, con:
            // ['in: admin, persona, mascota'] el usuario debera escribir y solo se podra registrar con esas 
            //palabras que le indiquemos
        ]);

        //Si no hay inamgen no haremos nada, si hay la guardaremos
        if($request->imagen) {
            $imagen = $request->file('imagen');

            //Dando un id unico para cada una de la imagenes
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
            //La imagen que se va guardar en el servidor
            $imagenServidor = Image::make($imagen);
    
            //Dando la dimension de la imagen
            $imagenServidor->fit(1000, 1000);//En este punto la imagen se encuentra en memoria, no en el servidor aun
    
            //Estableciendo la ruta donde se guardaran las imagenes
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
    
            //Guardando la imagen en el servidor segun la ruta (path) establecida
            $imagenServidor->save($imagenPath);
        } 

        //Guardar cambios
        $usuario = User::find(auth()->user()->id);//Buscamos el usuario por su id

        $usuario->username = $request->username;
        $usuario->email = $request->email;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? '';

        $usuario->save();

        //Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
