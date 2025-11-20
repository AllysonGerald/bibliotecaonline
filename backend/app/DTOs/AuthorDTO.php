<?php

declare(strict_types=1);

namespace App\DTOs;

use Carbon\Carbon;

/**
 * DTO (Data Transfer Object) para transferência de dados de autor.
 */
final readonly class AuthorDTO
{
    /**
     * @param string $nome Nome do autor
     * @param string|null $biografia Biografia do autor
     * @param string|null $dataNascimento Data de nascimento do autor (formato Y-m-d)
     * @param string|null $foto Caminho da foto do autor
     */
    public function __construct(
        public string $nome,
        public ?string $biografia = null,
        public ?string $dataNascimento = null,
        public ?string $foto = null,
    ) {
    }

    /**
     * Converte o DTO para array associativo.
     *
     * @return array<string, mixed> Dados do autor em formato array
     */
    public function toArray(): array
    {
        $data = [
            'nome' => $this->nome,
            'biografia' => $this->biografia,
            'foto' => $this->foto,
        ];

        if ($this->dataNascimento !== null) {
            $data['data_nascimento'] = Carbon::parse($this->dataNascimento)->format('Y-m-d');
        }

        return $data;
    }
}
