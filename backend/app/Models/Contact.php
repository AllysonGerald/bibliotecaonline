<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $casts = [
        'lido' => 'boolean',
        'lido_em' => 'datetime',
    ];

    protected $fillable = [
        'nome',
        'email',
        'assunto',
        'mensagem',
        'lido',
        'lido_em',
    ];

    public function markAsRead(): void
    {
        $this->update([
            'lido' => true,
            'lido_em' => now(),
        ]);
    }

    public function scopeRead($query)
    {
        return $query->where('lido', true);
    }

    public function scopeUnread($query)
    {
        return $query->where('lido', false);
    }

    protected static function newFactory(): ContactFactory
    {
        return ContactFactory::new();
    }
}
