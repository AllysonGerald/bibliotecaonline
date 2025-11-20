<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('livro_tag');
    }

    public function up(): void
    {
        Schema::create('livro_tag', static function (Blueprint $table): void {
            $table->foreignId('livro_id')->constrained('livros')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');

            $table->primary(['livro_id', 'tag_id']);
        });
    }
};
