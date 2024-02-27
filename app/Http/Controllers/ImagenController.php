<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImagenController extends Controller
{
    //En este metodo almacenaremos las imagenes (En general los store() toman Request $request)
    public function store(Request $request) 
    {
        //Esta es la imagen que vamos a subir
        $imagen = $request->file('file');

        //Dando un id unico para cada una de la imagenes
        $nombreImagen = Str::uuid() . "." . $imagen->extension();

        //La imagen que se va guardar en el servidor
        $imagenServidor = Image::make($imagen);

        //Dando la dimension de la imagen
        $imagenServidor->fit(1000, 1000);//En este punto la imagen se encuentra en memoria, no en el servidor aun

        //Estableciendo la ruta donde se guardaran las imagenes
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;

        //Guardando la imagen en el servidor segun la ruta (path) establecida
        $imagenServidor->save($imagenPath);
 
        //Y lo convertimos a json, pasando la imagen y la extension de la misma
        return response()->json( ['imagen' => $nombreImagen] );
    }
}
