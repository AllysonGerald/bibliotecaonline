<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Model que representa uma tag no sistema.
 */
class Tag extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nome',
    ];

    /**
     * Nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'tags';

    /**
     * Retorna a relação com os livros que possuem esta tag.
     *
     * @return BelongsToMany Relação com livros
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'livro_tag', 'tag_id', 'livro_id');
    }
}
