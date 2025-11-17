<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');
            $table->foreignId('autor_id')->constrained('autores')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->string('isbn', 20)->unique()->nullable();
            $table->string('editora')->nullable();
            $table->integer('ano_publicacao')->nullable();
            $table->integer('paginas')->nullable();
            $table->decimal('preco', 10, 2);
            $table->string('imagem_capa')->nullable();
            $table->enum('status', ['disponivel', 'reservado', 'alugado'])->default('disponivel');
            $table->integer('quantidade')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
