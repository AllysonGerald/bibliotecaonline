<?php

declare(strict_types=1);

namespace App\DTOs;

/**
 * DTO (Data Transfer Object) para transferência de dados de mensagem de contato.
 */
final readonly class ContactDTO
{
    /**
     * @param string $nome Nome do remetente
     * @param string $email Email do remetente
     * @param string $assunto Assunto da mensagem
     * @param string $mensagem Conteúdo da mensagem
     */
    public function __construct(
        public string $nome,
        public string $email,
        public string $assunto,
        public string $mensagem,
    ) {
    }

    /**
     * Converte o DTO para array associativo.
     *
     * @return array<string, mixed> Dados da mensagem em formato array
     */
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
