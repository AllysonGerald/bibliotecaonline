<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service responsável pela lógica de negócio relacionada a tags.
 */
class TagService
{
    /**
     * Retorna todas as tags ordenadas por nome.
     * Utilizado para preencher dropdowns em formulários.
     *
     * @return Collection Todas as tags ordenadas
     */
    public function getAllOrdered(): Collection
    {
        return Tag::orderBy('nome')->get();
    }
}
