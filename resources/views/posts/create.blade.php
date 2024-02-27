@extends('layouts.app')

@section('titulo')
    Crea una nueva publicacion
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> 
@endpush

@section('contenido')
    <div class="md:flex md:items-center">
        <div class="md:w-1/2 px-10"><!--w-1/2 es igual a w-6/12-->
            <form action="{{ route('imagenes.store') }}" method="POST" id="dropzone" enctype="multipart/form-data"
            class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center">
                @csrf
            </form>
        </div>
        <div class="md:w-1/2 px-10 bg-white p-10 rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="titulo" class="mb-2 block uppercase text-gray-500 font-bold">
                        Titulo
                    </label>
                    <input 
                        type="text" 
                        name="titulo" 
                        id="titulo"
                        placeholder="Ingresa el titulo de la publicacion"
                        class="border p-3 w-full rounded-lg @error('name')
                            border-red-500
                        @enderror"
                        value="{{ old('titulo') }}"><!--Mantenemos el valor e el campo al usuario recargar la pagina-->

                        @error('titulo')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-center font-bold
                            p-2"> {{$message}} </p>    
                        @enderror

                </div>

                <div class="mb-5">
                    <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Descripcion
                    </label>
                    <textarea 
                        name="descripcion" 
                        id="descripcion"
                        placeholder="Ingresa la descripcion de la publicacion"
                        class="border p-3 w-full rounded-lg @error('name')
                            border-red-500
                        @enderror"> {{ old('descripcion') }} </textarea><!--Mantenemos el valor e el campo al usuario recargar la pagina-->

                        @error('descripcion')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-center font-bold
                            p-2"> {{$message}} </p>    
                        @enderror

                </div>

                <div class="mb-5">
                    <input 
                        type="hidden" 
                        name="imagen" 
                        id="imagen"
                        value="{{ old('imagen') }}">

                        @error('imagen')
                            <p class="bg-red-500 text-white my-2 rounded-lg text-center font-bold
                            p-2"> {{$message}} </p>    
                        @enderror
                </div>

                <input 
                    type="submit" 
                    name="" 
                    id="" 
                    class="bg-sky-600 hover:bg-sky-800 transition-colors cursor-pointer uppercase font-bold
                    w-full p-3 text-white rounded-lg"
                    value="Crear publicacion">

            </form>
        </div>
    </div>
@endsection