@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}" class="rounded">

            <div class="p-3 flex items-center gap-4">
            
                @auth

                    <livewire:like-post :post="$post" />

                @endauth
            </div>

            <div><!--$post es la vrble que pasamos desde el PostController. user es el metodo que relaciona
            en Post.php a el post con el username-->
                <p class="font-bold">{{ $post->user->username }}</p>
                <!--created_at es una tabla automatica con la migracion-->
                <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                <p class="mt-5">{{ $post->descripcion }}</p>
            </div>

            @auth
            <!--($post->user_id: es el usuario que creo la publicacion. Y si es igual (===) a la personas que
            esta autenticada, vamos a mostrarele el boton de eliminar-->
                @if ($post->user_id === auth()->user()->id)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST"><!--POST ya que el navegador no soporta el metodo DELETE-->
                        <!--method spoofing en laravel para poder usar DELETE-->
                    @method('DELETE')<!--Como el propio navegador no lo soprta, pasamos el DELETE o PUT aqui-->
                    @csrf
                        <input 
                            type="submit" 
                            name="" 
                            id=""
                            class="bg-red-500 hover:bg-red-700 p-2 rounded text-white font-bold mt-4 cursor-pointer"
                            value="Eliminar publicacion">
                    </form>
                @endif
            @endauth

        </div>
        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5 rounded">
                
            @auth <!--Si el usuario no esta auth no podra ver esta parte-->
    
                <p class="text-xl font-bold text-center mb-4">Agrega un nuevo comentario</p>

                <!--Los with (desde ComentarioController) se imprimer con un session-->
                @if (session('mensaje'))
                    <div class="bg-green-400 p-2 rounded-lg mb-6 text-white uppercase font-bold text-center">
                        {{ session('mensaje') }}
                    </div>
                @endif

                <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" method="POST">
                    @csrf
                    <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                        Comentarios
                    </label>
                    <textarea 
                        name="comentario" 
                        id="comentario"
                        placeholder="Agrega un comentario"
                        class="border p-3 w-full rounded-lg @error('name')
                            border-red-500
                        @enderror"></textarea>

                        @error('comentario')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-center font-bold
                            p-2"> {{$message}} </p>    
                        @enderror

                        <input 
                    type="submit" 
                    name="" 
                    id="" 
                    class="bg-sky-600 hover:bg-sky-800 transition-colors cursor-pointer uppercase font-bold
                    w-full p-3 text-white rounded-lg mt-5"
                    value="Comentar">
                </form>
                
            @endauth

            <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-3">
                @if ($post->comentarios->count())

                    @foreach ($post->comentarios as $comentario)
                        <div class="p-5 border-gray-400 border-b">
                            <a href="{{ route('posts.index', $comentario->user) }}" class="font-bold hover:text-blue-900">
                                {{ $comentario->user->username }}
                            </a>
                            <!--$comenatior del foreach y comentario de la columna de la tabla-->
                            <p>{{ $comentario->comentario }}</p>
                            <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach

                @else
                    <p class="p-10 text-center">No hay comentarios aun</p>
                @endif
            </div>

            </div>
        </div>
    </div>
@endsection