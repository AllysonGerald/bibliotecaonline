<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $casts = [
        'nota' => 'integer',
    ];

    protected $fillable = [
        'usuario_id',
        'livro_id',
        'nota',
        'comentario',
    ];

    protected $table = 'avaliacoes';

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'livro_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
