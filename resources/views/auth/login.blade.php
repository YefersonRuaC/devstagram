@extends('layouts.app')

@section('titulo')
    Inicia sesion en Devstagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{ asset('img/login.jpg') }}" alt="Imagen login">
        </div>

        <div class="md:w-5/12 bg-white p-6 rounded-lg shadow-xl">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if(session('mensaje'))<!--Si hay un mensaje, lo imprimiremos-->
                    <p class="bg-red-500 text-white my-2 rounded-lg text-center font-bold p-2"> 
                        {{ session('mensaje') }} 
                    </p>
                @endif


                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        placeholder="Ingresa tu email de registro"
                        class="border p-3 w-full rounded-lg @error('email')
                            border-red-500
                        @enderror"
                        value="{{ old('email') }}">

                        @error('email')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-center font-bold
                            p-2"> {{$message}} </p>    
                        @enderror

                </div>
                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Password
                    </label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password"
                        placeholder="Ingresa tu password"
                        class="border p-3 w-full rounded-lg @error('password')
                            border-red-500
                        @enderror">

                        @error('password')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-center font-bold
                            p-2"> {{$message}} </p>    
                        @enderror

                </div>

                <div class="mb-5">
                    <input type="checkbox" name="remember" id="">
                        <label for="" class="text-gray-500 text-sm">
                            Mantener mi sesion activa
                        </label>
                </div>

                <input 
                    type="submit" 
                    name="" 
                    id="" 
                    class="bg-sky-600 hover:bg-sky-800 transition-colors cursor-pointer uppercase font-bold
                    w-full p-3 text-white rounded-lg"
                    value="Iniciar sesion">
            </form>
        </div>
    </div>
@endsection

