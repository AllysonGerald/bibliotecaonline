<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model que representa uma mensagem de contato no sistema.
 */
class Contact extends Model
{
    use HasFactory;

    /**
     * Atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lido' => 'boolean',
        'lido_em' => 'datetime',
    ];

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nome',
        'email',
        'assunto',
        'mensagem',
        'lido',
        'lido_em',
    ];

    /**
     * Marca a mensagem como lida.
     */
    public function markAsRead(): void
    {
        $this->update([
            'lido' => true,
            'lido_em' => now(),
        ]);
    }

    /**
     * Scope para filtrar apenas mensagens lidas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeRead($query)
    {
        return $query->where('lido', true);
    }

    /**
     * Scope para filtrar apenas mensagens não lidas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeUnread($query)
    {
        return $query->where('lido', false);
    }

    protected static function newFactory(): ContactFactory
    {
        return ContactFactory::new();
    }
}
