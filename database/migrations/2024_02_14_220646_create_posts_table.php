<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');//String es el varchar de sql
            $table->text('descripcion');//text seria el text de sql, que recibe muchas mas info en un varchar
            $table->string('imagen');
            //'cascade' Si se elimina un usuario, se van tambien sus posts
            $table->foreignId('user_id')->constrained()->onDelete('cascade');//Seria el foreign key de la tabla 
            //users. Al seguir estas convenciones laravel detecta de que esta foreign key esta relacionada con 
            //el id de la tabla users
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
