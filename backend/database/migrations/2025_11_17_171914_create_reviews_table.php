<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->integer('nota');
            $table->text('comentario')->nullable();
            $table->timestamps();
            
            $table->unique(['usuario_id', 'livro_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
