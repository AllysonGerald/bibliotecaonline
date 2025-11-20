<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model que representa uma multa no sistema.
 */
class Fine extends Model
{
    use HasFactory;

    /**
     * Atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'valor' => 'decimal:2',
        'paga' => 'boolean',
        'paga_em' => 'datetime',
    ];

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'aluguel_id',
        'usuario_id',
        'valor',
        'paga',
        'paga_em',
    ];

    /**
     * Nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'multas';

    /**
     * Marca a multa como paga.
     */
    public function markAsPaid(): void
    {
        $this->update([
            'paga' => true,
            'paga_em' => now(),
        ]);
    }

    /**
     * Retorna a relação com o aluguel que gerou a multa.
     *
     * @return BelongsTo Relação com aluguel
     */
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class, 'aluguel_id');
    }

    /**
     * Scope para filtrar apenas multas não pagas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeUnpaid($query)
    {
        return $query->where('paga', false);
    }

    /**
     * Retorna a relação com o usuário que deve pagar a multa.
     *
     * @return BelongsTo Relação com usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
