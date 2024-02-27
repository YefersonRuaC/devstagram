<!--En laravel no ponemos "/" para entrar a una carpeta, si no un "."-->
@extends('layouts.app')

@section('titulo')
    Pagina principal
@endsection

@section('contenido')
    {{-- <!--Llamar un componente-->
    <x-listar-post><!--De esta manera (con $slot) podemos reutilizar nustros componentes haciendolos dinamicos-->

        <x-slot:titulo>
            <header>Header de slot personalizado</header>
        </x-slot:titulo>

        <h1>Probando mi primer slot</h1>
    </x-listar-post> --}}

    <x-listar-post :posts="$posts" />

@endsection