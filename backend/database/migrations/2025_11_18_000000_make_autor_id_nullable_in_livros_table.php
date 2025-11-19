<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('livros', function (Blueprint $table): void {
            // Remover a foreign key existente
            $table->dropForeign(['autor_id']);

            // Tornar autor_id nullable
            $table->foreignId('autor_id')->nullable()->change();

            // Recriar a foreign key com onDelete('set null') para não deletar livros quando autor for deletado
            $table->foreign('autor_id')
                ->references('id')
                ->on('autores')
                ->onDelete('set null')
            ;
        });
    }

    public function down(): void
    {
        Schema::table('livros', function (Blueprint $table): void {
            // Remover a foreign key
            $table->dropForeign(['autor_id']);

            // Tornar autor_id obrigatório novamente
            $table->foreignId('autor_id')->nullable(false)->change();

            // Recriar a foreign key original com onDelete('cascade')
            $table->foreign('autor_id')
                ->references('id')
                ->on('autores')
                ->onDelete('cascade')
            ;
        });
    }
};
