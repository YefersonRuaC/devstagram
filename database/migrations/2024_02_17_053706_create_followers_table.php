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
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            //Aqui, laravel sale que un "user_id" ira relacionado con una tabla llamada "users"
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            //Podriamos pasar igual la tabla, pero al seguir la convencion de laravel no es necesario
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            //Como no tenemos una tabla llama followers, no podemos seguir la convenciones de laravel
            //Entonces, para indicarle a que tabla nos referimos, se la debemos pasar
            $table->foreignId('follower_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
