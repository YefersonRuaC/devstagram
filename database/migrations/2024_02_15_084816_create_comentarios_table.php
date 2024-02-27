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
    {//Esta seria una tabla pivote
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            //Si un usuario elimina su cuenta, tambien se eliminara sus comentarios de la BD
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            //Si un usuario elimina una publicacion, tambien elimina sus comentarios de la BD
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->string('comentario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
