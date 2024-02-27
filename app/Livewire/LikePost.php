<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
//Desde que registremos la vrble aqui, ya esta disponible en la vista, no es necesario pasarla manualmente en view
    public $post;
    public $isLiked;
    public $likes;

    //mount Se ejecutara apenas sea instanciado el post (sea mostrado). E scomo un __construct en php 
    public function mount($post)
    {
        //Le pasamos el $post para que sepa que info debe mostrar. Es decir que revisa mediante el usuario si ya
        //habia dado like a esa publicacion o no
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        if( $this->post->checkLike(auth()->user()) ) {

            // $this->post->likes()->where('post_id', $this->post->id)->delete();
            $this->post->likes()->where('user_id', auth()->user()->id)->delete();
            //Si no le ha dado like
            $this->isLiked = false;
            $this->likes--;

        } else {

            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            //Si ya le dio like
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
