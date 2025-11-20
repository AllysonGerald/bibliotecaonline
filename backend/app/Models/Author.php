<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model que representa um autor no sistema.
 */
class Author extends Model
{
    use HasFactory;

    /**
     * Atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data_nascimento' => 'date',
    ];

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nome',
        'biografia',
        'data_nascimento',
        'foto',
    ];

    /**
     * Nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'autores';

    /**
     * Retorna a relação com os livros do autor.
     *
     * @return HasMany Relação com livros
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'autor_id');
    }
}
