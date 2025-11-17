<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    protected $table = 'autores';

    protected $fillable = [
        'nome',
        'biografia',
        'data_nascimento',
        'foto',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'autor_id');
    }
}
