<?php

declare(strict_types=1);

namespace App\DTOs;

use Carbon\Carbon;

final readonly class AuthorDTO
{
    public function __construct(
        public string $nome,
        public ?string $biografia = null,
        public ?string $dataNascimento = null,
        public ?string $foto = null,
    ) {
    }

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
