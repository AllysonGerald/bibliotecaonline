<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RentalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Rental extends Model
{
    use HasFactory;

    protected $casts = [
        'alugado_em' => 'datetime',
        'data_devolucao' => 'datetime',
        'devolvido_em' => 'datetime',
        'taxa_atraso' => 'decimal:2',
        'status' => RentalStatus::class,
    ];

    protected $fillable = [
        'usuario_id',
        'livro_id',
        'alugado_em',
        'data_devolucao',
        'devolvido_em',
        'taxa_atraso',
        'status',
    ];

    protected $table = 'alugueis';

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'livro_id');
    }

    public function daysOverdue(): int
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return (int) now()->diffInDays($this->data_devolucao);
    }

    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class, 'aluguel_id');
    }

    public function isOverdue(): bool
    {
        return $this->status === RentalStatus::ATIVO
            && $this->data_devolucao->isPast();
    }

    public function scopeActive($query)
    {
        return $query->where('status', RentalStatus::ATIVO);
    }

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
