<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('multas', static function (Blueprint $table): void {
            $table->dropColumn(['pagamento_solicitado', 'pagamento_solicitado_em']);
        });
    }
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('multas', static function (Blueprint $table): void {
            $table->boolean('pagamento_solicitado')->default(false)->after('paga');
            $table->dateTime('pagamento_solicitado_em')->nullable()->after('pagamento_solicitado');
        });
    }
};
