<?php

declare(strict_types=1);

namespace App\DTOs;

final readonly class ContactDTO
{
    public function __construct(
        public string $nome,
        public string $email,
        public string $assunto,
        public string $mensagem,
    ) {
    }

    public function toArray(): array
    {
        return [
            'nome' => $this->nome,
            'email' => $this->email,
            'assunto' => $this->assunto,
            'mensagem' => $this->mensagem,
        ];
    }
}
