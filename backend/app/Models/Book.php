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

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'livros';

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

    protected $casts = [
        'preco' => 'decimal:2',
        'ano_publicacao' => 'integer',
        'paginas' => 'integer',
        'quantidade' => 'integer',
        'status' => BookStatus::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'autor_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categoria_id');
    }

    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class, 'livro_id');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'livro_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'livro_id');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'livro_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'livro_tag', 'livro_id', 'tag_id');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', BookStatus::DISPONIVEL);
    }

    public function scopeByCategory($query, int $categoryId)
    {
        return $query->where('categoria_id', $categoryId);
    }

    public function scopeByAuthor($query, int $authorId)
    {
        return $query->where('autor_id', $authorId);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where('titulo', 'like', "%{$term}%")
            ->orWhere('descricao', 'like', "%{$term}%")
            ->orWhereHas('author', fn ($q) => $q->where('nome', 'like', "%{$term}%"))
        ;
    }

    public function averageRating(): float
    {
        return (float) $this->reviews()->avg('nota') ?? 0.0;
    }

    public function isAvailable(): bool
    {
        return $this->status === BookStatus::DISPONIVEL && ($this->quantidade === null || $this->quantidade > 0);
    }
}
