<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';

    protected $fillable = [
        'usuario_id',
        'livro_id',
        'nota',
        'comentario',
    ];

    protected $casts = [
        'nota' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'livro_id');
    }
}
