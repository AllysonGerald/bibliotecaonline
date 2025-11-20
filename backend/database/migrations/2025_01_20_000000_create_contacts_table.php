<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }

    public function up(): void
    {
        Schema::create('contacts', static function (Blueprint $table): void {
            $table->id();
            $table->string('nome', 255);
            $table->string('email', 255);
            $table->string('assunto', 255);
            $table->text('mensagem', 5000);
            $table->boolean('lido')->default(false);
            $table->timestamp('lido_em')->nullable();
            $table->timestamps();
        });
    }
};
