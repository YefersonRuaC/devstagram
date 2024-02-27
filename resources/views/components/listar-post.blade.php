<div>
    {{-- {{ $titulo }}<!--slot perzonalizado-->
    <h1>{{ $slot }}</h1><!--Este $slot es el default de contenido de una etiqueta--> --}}

    <!--Mensaje de manera condicional si el usuario no tiene posts-->
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div>
                    <!--Al haber una vrble en la ruta, debemos pasarle $post ya que este viene son el id especifico del post
                    Esto nos ahorra mucho codigo (route-model-biding) ya que no dbemos validar si el id existe, no consultar
                    la BD, automaticamente esot hace todo por nosotros-->
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen post {{ $post->titulo }}">
                    </a>
                </div>
            @endforeach
            </div>
        
            <div class="mt-10">
                {{ $posts->links('pagination::tailwind') }}
                <!--Funciona de las dos maneras-->
                <!--{{ $posts->links() }}-->
            </div>
    @else
        <p class="text-center">No hay Posts aun</p>    
    @endif

</div>