@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')

<div class="flex justify-center">
    <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row"> 
        <div class="w-8/12 lg:w-6/12 px-5">
            <!--Condicional por si el usuario no tiene imagend e perfil-->
            <img src="{{ $user->imagen ? 
                    asset('perfiles') . '/' . $user->imagen : 
                    asset('img/usuario.svg') }}" 
            alt="Imagen perfil" class="rounded"><!--asset() apunta directamente a public-->
        </div>
        <!--md, sm: hace referencia al media querie que queremos aplicar en ese tamaño-->
        <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start
         py-10 md:py-10">
            <div class="flex items-center gap-2">
            <!--Como quitamos auth()->user()->username, este se debe agregar en el redirect() de LoginController-->
                <p class="text-gray-700 text-2xl">{{ $user->username }}</p><!--Imprimir el username de usuario-->

                @auth
                <!--Si el perfil auctual es el mismo que la persona que esta autenticado-->
                    @if ($user->id  === auth()->user()->id )
                        <a href="{{ route('perfil.index') }}" 
                        class="text-gray-500 cursor-pointer hover:text-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>                              
                        </a>
                    @endif
                @endauth
            </div>

            <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                {{ $user->followers->count() }}
                <span class="font-normal"> @choice('Seguidor|Seguidores', $user->followers->count() ) </span>
            </p>

            <p class="text-gray-800 text-sm mb-3 font-bold">
                {{ $user->follows->count() }}
                <span class="font-normal">@choice('Seguido|Seguidos', $user->follows->count() )</span>
            </p>

            <p class="text-gray-800 text-sm mb-3 font-bold">
                {{ $user->posts->count() }}
                <span class="font-normal">Posts</span>
            </p>

            @auth
            <!--Este condicional evita que el dueño del perfil se pueda seguir a si mismo-->
                @if ($user->id !== auth()->user()->id ) 
                    <!--Este $user es el perfil que estamos visitando (al que podemos darle en seguir)
                    Y auth()->user es la persona que esta visitando el perfil-->
                    @if (!$user->siguiendo( auth()->user() ))    
                        <!--Este $user es el perfil que estamos visitando (al que podemos darle en seguir)-->
                        <form action="{{ route('users.follow', $user) }}" method="POST">
                            @csrf

                            <input 
                                type="submit" 
                                class="bg-blue-700 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold 
                                cursor-pointer p-5 hover:bg-blue-500"
                                value="Seguir">
                        </form>

                    @else

                        <form action="{{ route('users.unfollow', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <input 
                                type="submit" 
                                class="bg-red-700 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold 
                                cursor-pointer p-5 hover:bg-red-600"
                                value="Dejar de seguir">
                        </form>
                    @endif
                @endif
            @endauth
        </div>
    </div>
</div>

<section class="container mx-auto mt-10">
    <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
    
    <x-listar-post :posts="$posts" />

</section>

@endsection