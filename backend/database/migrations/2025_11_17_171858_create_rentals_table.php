<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alugueis', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->dateTime('alugado_em');
            $table->dateTime('data_devolucao');
            $table->dateTime('devolvido_em')->nullable();
            $table->decimal('taxa_atraso', 10, 2)->default(0);
            $table->enum('status', ['ativo', 'devolvido', 'atrasado'])->default('ativo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alugueis');
    }
};
