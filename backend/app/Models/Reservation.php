<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $casts = [
        'reservado_em' => 'datetime',
        'expira_em' => 'datetime',
        'status' => ReservationStatus::class,
    ];

    protected $fillable = [
        'usuario_id',
        'livro_id',
        'reservado_em',
        'expira_em',
        'status',
    ];

    protected $table = 'reservas';

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'livro_id');
    }

    public function isExpired(): bool
    {
        return $this->status === ReservationStatus::PENDENTE
            && $this->expira_em->isPast();
    }

    public function scopeActive($query)
    {
        return $query->where('status', ReservationStatus::PENDENTE)
            ->orWhere('status', ReservationStatus::CONFIRMADA)
        ;
    }

    public function scopeExpired($query)
    {
        return $query->where('expira_em', '<', now())
            ->where('status', ReservationStatus::PENDENTE)
        ;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
