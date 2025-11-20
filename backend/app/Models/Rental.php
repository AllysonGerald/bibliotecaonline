<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RentalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Model que representa um aluguel no sistema.
 */
class Rental extends Model
{
    use HasFactory;

    /**
     * Atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'alugado_em' => 'datetime',
        'data_devolucao' => 'datetime',
        'devolvido_em' => 'datetime',
        'taxa_atraso' => 'decimal:2',
        'status' => RentalStatus::class,
    ];

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'usuario_id',
        'livro_id',
        'alugado_em',
        'data_devolucao',
        'devolvido_em',
        'taxa_atraso',
        'status',
    ];

    /**
     * Nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'alugueis';

    /**
     * Retorna a relação com o livro alugado.
     *
     * @return BelongsTo Relação com livro
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'livro_id');
    }

    /**
     * Calcula a quantidade de dias em atraso.
     *
     * @return int Quantidade de dias em atraso (0 se não estiver atrasado)
     */
    public function daysOverdue(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return (int) now()->diffInDays($this->data_devolucao);
    }

    /**
     * Retorna a relação com a multa associada ao aluguel.
     *
     * @return HasOne Relação com multa
     */
    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class, 'aluguel_id');
    }

    /**
     * Verifica se o aluguel está em atraso.
     *
     * @return bool True se o aluguel estiver atrasado
     */
    public function isOverdue(): bool
    {
        return $this->status === RentalStatus::ATIVO
            && $this->data_devolucao->isPast();
    }

    /**
     * Scope para filtrar apenas aluguéis ativos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeActive($query)
    {
        return $query->where('status', RentalStatus::ATIVO);
    }

    /**
     * Scope para filtrar apenas aluguéis em atraso.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', RentalStatus::ATRASADO)
            ->orWhere(static function ($q): void {
                $q->where('status', RentalStatus::ATIVO)
                    ->where('data_devolucao', '<', now())
                ;
            })
        ;
    }

    /**
     * Retorna a relação com o usuário que realizou o aluguel.
     *
     * @return BelongsTo Relação com usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
