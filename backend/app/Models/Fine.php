<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fine extends Model
{
    use HasFactory;

    protected $casts = [
        'valor' => 'decimal:2',
        'paga' => 'boolean',
        'paga_em' => 'datetime',
    ];

    protected $fillable = [
        'aluguel_id',
        'usuario_id',
        'valor',
        'paga',
        'paga_em',
    ];

    protected $table = 'multas';

    public function markAsPaid(): void
    {
        $this->update([
            'paga' => true,
            'paga_em' => now(),
        ]);
    }

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class, 'aluguel_id');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('paga', false);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
