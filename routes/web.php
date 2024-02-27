<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('principal');
// });
//Como esta relacionado con un metodo __invoke(), solod ebemos pasar el nombre del controlador
Route::get('/', HomeController::class)->name('home');

//->name(hace referencia la el nombre de la url que queremos tomar) . Y '/register' es el nombre (cualquiera)
//que le queramos poner a esa url 
Route::get('/register', [RegisterController::class, 'index'])->name('crear-cuenta');
Route::post('/register', [RegisterController::class, 'store'])->name('crear-cuenta');//Aunque solo dejando en name-> de arriba funciona (si las rutas tienen el mismo nombre)

Route::get('/login', [LoginController::class, 'index'])->name('login');//index: mostrar informacion
Route::post('/login', [LoginController::class, 'store'])->name('login');//store: para almacenar informacion

Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

//Rutas para el perfil (edicion).
Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

//Para evitar confusiones llamamos como create, la vista (create.blade.php), el metodo del controlador (create()
//en PostController.php) y la ruta posts.create
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');//create muestra el formulario (el metodo siempre retorna una vista)
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');//store almacena la info en la BD
//Eliminar un post del perfil
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::post('/{user:username}/post/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');

//Like a las fotos
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

//EN METODO GET: ESTAS url CON VARIABLES ES RECOMENDABLE PONERLAS EN LA PARTE DE ABAJO DE TODAS ESTAS RUTAS

//URL dinamicas: 'user' es el nombre del modelos en este caso User.php. Que viene desde PostController
//Indicamos que, del modelo user, se muestre el la url el username del usuario
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
// {user:username} evita que parezca el id en numero en la url, muestra es el nombre de usuario
Route::get('/{user:username}/post/{post}', [PostController::class, 'show'])->name('posts.show');

//Siguiendo usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');