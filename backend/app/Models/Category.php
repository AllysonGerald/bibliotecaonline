<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Model que representa uma categoria no sistema.
 */
class Category extends Model
{
    use HasFactory;

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nome',
        'descricao',
        'icone',
    ];

    /**
     * Nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'categorias';

    /**
     * Retorna a relação com os livros da categoria.
     *
     * @return HasMany Relação com livros
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'categoria_id');
    }
}
