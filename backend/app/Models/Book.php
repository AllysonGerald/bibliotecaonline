<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BookStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model que representa um livro no sistema.
 */
class Book extends Model
{
    use HasFactory;

    use SoftDeletes;

    /**
     * Atributos que devem ser convertidos para tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'preco' => 'decimal:2',
        'ano_publicacao' => 'integer',
        'paginas' => 'integer',
        'quantidade' => 'integer',
        'status' => BookStatus::class,
    ];

    /**
     * Atributos que podem ser preenchidos em massa.
     *
     * @var array<string>
     */
    protected $fillable = [
        'titulo',
        'descricao',
        'autor_id',
        'categoria_id',
        'isbn',
        'editora',
        'ano_publicacao',
        'paginas',
        'preco',
        'imagem_capa',
        'status',
        'quantidade',
    ];

    /**
     * Nome da tabela associada ao model.
     *
     * @var string
     */
    protected $table = 'livros';

    /**
     * Retorna a relação com o autor do livro.
     *
     * @return BelongsTo Relação com autor
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'autor_id');
    }

    /**
     * Calcula a média de avaliações do livro.
     *
     * @return float Média de avaliações (0.0 se não houver avaliações)
     */
    public function averageRating(): float
    {
        return (float) $this->reviews()->avg('nota') ?? 0.0;
    }

    /**
     * Retorna a relação com a categoria do livro.
     *
     * @return BelongsTo Relação com categoria
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    /**
     * Verifica se o livro está disponível para aluguel.
     *
     * @return bool True se o livro estiver disponível
     */
    public function isAvailable(): bool
    {
        if ($this->status !== BookStatus::DISPONIVEL) {
            return false;
        }

        if ($this->quantidade === null) {
            return true;
        }

        return $this->quantidade > 0;
    }

    /**
     * Retorna a relação com os aluguéis do livro.
     *
     * @return HasMany Relação com aluguéis
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class, 'livro_id');
    }

    /**
     * Retorna a relação com as reservas do livro.
     *
     * @return HasMany Relação com reservas
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'livro_id');
    }

    /**
     * Retorna a relação com as avaliações do livro.
     *
     * @return HasMany Relação com avaliações
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'livro_id');
    }

    /**
     * Scope para filtrar apenas livros disponíveis.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', BookStatus::DISPONIVEL);
    }

    /**
     * Scope para filtrar livros por autor.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @param int $authorId ID do autor
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeByAuthor($query, int $authorId)
    {
        return $query->where('autor_id', $authorId);
    }

    /**
     * Scope para filtrar livros por categoria.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @param int $categoryId ID da categoria
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('categoria_id', $categoryId);
    }

    /**
     * Scope para buscar livros por termo de pesquisa.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Query builder
     * @param string $term Termo de busca
     * @return \Illuminate\Database\Eloquent\Builder Query filtrada
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where('titulo', 'like', "%{$term}%")
            ->orWhere('descricao', 'like', "%{$term}%")
            ->orWhereHas('author', static fn ($q) => $q->where('nome', 'like', "%{$term}%"))
        ;
    }

    /**
     * Retorna a relação com as tags do livro.
     *
     * @return BelongsToMany Relação com tags
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'livro_tag', 'livro_id', 'tag_id');
    }

    /**
     * Retorna a relação com as listas de desejos que contêm o livro.
     *
     * @return HasMany Relação com listas de desejos
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'livro_id');
    }
}
