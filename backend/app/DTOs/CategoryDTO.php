<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * DTO (Data Transfer Object) para transferência de dados de categoria.
 */
final readonly class CategoryDTO
{
    /**
     * @param string $nome Nome da categoria
     * @param string|null $descricao Descrição da categoria
     * @param string|null $icone Ícone da categoria
     */
    public function __construct(
        public string $nome,
        public ?string $descricao = null,
        public ?string $icone = null,
    ) {
    }

    /**
     * Converte o DTO para array associativo.
     *
     * @return array<string, mixed> Dados da categoria em formato array
     */
    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'descricao' => $this->descricao,
            'icone' => $this->icone,
        ];
    }
}
