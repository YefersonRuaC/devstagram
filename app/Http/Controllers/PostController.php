<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    //Este metodo verifica que el usuario SI este autenticado para que lo deje entrar a todas estas paginas
    //que tiene que ver con POST
    public function __construct() 
    {//El usuario debe estar auth para acceder a los metodos siguientes a este
        //Con except, podemos permitir el acceso a ciertos metodos (como ver la publicaciones, etc) pero sin
        //dar todas las credenciales
        $this->middleware('auth')->except(['show', 'index']);
    }

    public function index(User $user) //Para tener URL dinamica pasamos el modelo de User y la vrble $user
    {
        //Estamos filtrando los posts que hay creados segun el id del usuario
        $posts = Post::where('user_id', $user->id)->latest()->paginate(4);//paginate() nos da la posibilidad de filtrar
        //cuantos registros queremos mostrar
        
        //view toma una vista y un arreglo con informacion
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create() 
    {
        //en views, posts es la carpeta y create el archivo
        return view('posts.create');
    }

    public function store(Request $request) 
    {
        //Validamos los campos
        $this->validate($request, [
            'titulo' => ['required', 'max:255'],
            'descripcion' => ['required'],
            'imagen' =>['required']
        ]);

        //Crearemos el post del usuario
        //FORMA 1: de crear registros (insertar) a nuestra BD
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

        //FORMA 2: de crear registros (insertar) a nuestra BD
        // $post = new POST;//Creamos una nueva instancia del modelo Post y lo vamos llenando
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;

        //FORMA 3: de crear registros (insertar) a nuestra BD, gracias a las relaciones
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        //Una vez creado el post, llevamos el usuario hacia su muro
        return redirect()->route('posts.index', [auth()->user()->username]);
    }

    //Para mostrar un recurso (unico) por su id
    public function show(User $user, Post $post) //Estas vrbles hacen parte del "route-model-biding". Ya traen el 
    //id y no es necesario de consultarlo o hacer validaciones desde la Bd si existe. Si no existe, o si el 
    {//usuario cambia la url, lo manda d euna para una pagina de error
        return view('posts.show', [
            'user' => $user,
            'post' => $post
        ]);
    }

    //Gracias a la vrble que pasamos en el Route({post}, 'destroy') en web.php. Y Post $post usamos el "Route-model-
    //biding" e identificamos a que post se le dio click (por media de la url) para ser eliminado (destroy)
    public function destroy(Post $post) 
    {
        //($post->user_id: es el usuario que creo la publicacion. Y si es igual (===) a la personas que esta 
        //autenticada, vamos a mostrarele el boton de elimina
        // if($post->user_id === auth()->user()->id) {
            
        // }else {
            
        // }

        //Usando Policy
        $this->authorize('delete', $post);

        //Si paso la autorizacion anterior, eliminamos el post
        $post->delete();

        //Eliminar la imagen
        $imagen_path = public_path('uploads/' . $post->imagen );

        if(File::exists($imagen_path)) {
            File::delete($imagen_path);
        }

        //Redireccionamos
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
