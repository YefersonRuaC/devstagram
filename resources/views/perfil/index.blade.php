@extends('layouts.app')

@section('titulo')
    Editar perfil: {{ auth()->user()->username }}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form action="{{ route('perfil.store') }}" class="mt-10 md:mt-0" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Username
                    </label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username"
                        placeholder="Ingresa tu nuevo username"
                        class="border p-3 w-full rounded-lg @error('username')
                            border-red-500
                        @enderror"
                        value="{{ auth()->user()->username }}"><!--Accediendo al valor que tiene el usuario, para cambiarlo-->

                        @error('username')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-center font-bold
                            p-2"> {{$message}} </p>    
                        @enderror

                </div>

                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        placeholder="Ingresa tu nuevo username"
                        class="border p-3 w-full rounded-lg @error('email')
                            border-red-500
                        @enderror"
                        value="{{ auth()->user()->email }}"><!--Accediendo al valor que tiene el usuario, para cambiarlo-->

                        @error('email')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-center font-bold
                            p-2"> {{$message}} </p>    
                        @enderror

                </div>

                <div class="mb-5">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">
                        Imagen perfil
                    </label>
                    <input 
                        type="file" 
                        name="imagen" 
                        id="imagen"
                        class="border p-3 w-full rounded-lg"
                        value=""
                        accept=".jpg, .jpeg, .png">
                </div>

                <input 
                    type="submit" 
                    name="" 
                    id="" 
                    class="bg-sky-600 hover:bg-sky-800 transition-colors cursor-pointer uppercase font-bold
                    w-full p-3 text-white rounded-lg"
                    value="Guardar cambios">
            </form>
        </div>
    </div>
@endsection