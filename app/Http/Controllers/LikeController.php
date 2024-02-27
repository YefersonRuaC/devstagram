<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, Post $post) //$request toma la info del usuario que esta dando like a el post
    {   
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        //En $request viene el usuario (user()). Con el usuario vienen los like() (desde User.php). Filtramos el
        //post (con where) del id que estamos quitando el like. Y eliminamos el like de la BD con delte()
        $request->user()->likes()->where('post_id', $post->id)->delete();

        return back();
    }
}
