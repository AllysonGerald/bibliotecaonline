<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }

    public function up(): void
    {
        Schema::create('categorias', static function (Blueprint $table): void {
            $table->id();
            $table->string('nome')->unique();
            $table->text('descricao')->nullable();
            $table->string('icone')->nullable();
            $table->timestamps();
        });
    }
};
