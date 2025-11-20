<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model que representa uma avaliação de livro no sistema.
 */
class Review extends Model
{
    use HasFactory;

    /**
     * Atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nota' => 'integer',
    ];

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'usuario_id',
        'livro_id',
        'nota',
        'comentario',
    ];

    /**
     * Nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'avaliacoes';

    /**
     * Retorna a relação com o livro avaliado.
     *
     * @return BelongsTo Relação com livro
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'livro_id');
    }

    /**
     * Retorna a relação com o usuário que fez a avaliação.
     *
     * @return BelongsTo Relação com usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
