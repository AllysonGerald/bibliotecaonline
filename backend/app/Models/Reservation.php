<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model que representa uma reserva no sistema.
 */
class Reservation extends Model
{
    use HasFactory;

    /**
     * Atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reservado_em' => 'datetime',
        'expira_em' => 'datetime',
        'status' => ReservationStatus::class,
    ];

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'usuario_id',
        'livro_id',
        'reservado_em',
        'expira_em',
        'status',
    ];

    /**
     * Nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'reservas';

    /**
     * Retorna a relação com o livro reservado.
     *
     * @return BelongsTo Relação com livro
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'livro_id');
    }

    /**
     * Verifica se a reserva está expirada.
     *
     * @return bool True se a reserva estiver expirada
     */
    public function isExpired(): bool
    {
        return $this->status === ReservationStatus::PENDENTE
            && $this->expira_em->isPast();
    }

    /**
     * Scope para filtrar apenas reservas ativas (pendentes ou confirmadas).
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeActive($query)
    {
        return $query->where('status', ReservationStatus::PENDENTE)
            ->orWhere('status', ReservationStatus::CONFIRMADA)
        ;
    }

    /**
     * Scope para filtrar apenas reservas expiradas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeExpired($query)
    {
        return $query->where('expira_em', '<', now())
            ->where('status', ReservationStatus::PENDENTE)
        ;
    }

    /**
     * Retorna a relação com o usuário que realizou a reserva.
     *
     * @return BelongsTo Relação com usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
