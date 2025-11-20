<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function down(): void
    {
        Schema::dropIfExists('multas');
    }

    public function up(): void
    {
        Schema::create('multas', static function (Blueprint $table): void {
            $table->id();
            $table->foreignId('aluguel_id')->constrained('alugueis')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->decimal('valor', 10, 2);
            $table->boolean('paga')->default(false);
            $table->dateTime('paga_em')->nullable();
            $table->timestamps();
        });
    }
};
