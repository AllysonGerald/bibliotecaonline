<?php

declare(strict_types=1);

namespace App\DTOs;

final readonly class CategoryDTO
{
    public function __construct(
        public string $nome,
        public ?string $descricao = null,
        public ?string $icone = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'icone' => $this->icone,
        ];
    }
}
