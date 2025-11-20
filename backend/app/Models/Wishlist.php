<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model que representa um item na lista de desejos de um usuário.
 */
class Wishlist extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'usuario_id',
        'livro_id',
    ];

    /**
     * Nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'lista_desejos';

    /**
     * Retorna a relação com o livro na lista de desejos.
     *
     * @return BelongsTo Relação com livro
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'livro_id');
    }

    /**
     * Retorna a relação com o usuário que possui o item na lista de desejos.
     *
     * @return BelongsTo Relação com usuário
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
