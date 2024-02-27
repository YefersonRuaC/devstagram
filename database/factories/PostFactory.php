<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [//De la tabla posts estos son los campos que queremos probar
            'titulo' => $this->faker->sentence(5),//sentence indica cuantas palabras se quieren utilizar
            'descripcion' => $this->faker->sentence(20),
            'imagen' => $this->faker->uuid() . '.jpg',//Aqui probamos que no se separe el id unico de la imagen y su extension
            'user_id' => $this->faker->randomElement([1, 6])//Estos id que pasemos deben existir todos en la bd
        ];
        //Lo que hacemos en este texting o "faker" es que el creara un post con titulo, descripcion e imagen de
        //forma aleatoria y va tomar uno de los tres user_id y se lo va asignar a ese post
    }
}
