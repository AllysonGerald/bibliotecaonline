<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\BookStatus;

final readonly class BookDTO
{
    public function __construct(
        public string $titulo,
        public string $descricao,
        public int $autorId,
        public int $categoriaId,
        public string $isbn,
        public string $editora,
        public int $anoPublicacao,
        public int $paginas,
        public float $preco,
        public BookStatus $status,
        public int $quantidade,
        public ?string $imagemCapa = null,
        public ?array $tags = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'autor_id' => $this->autorId,
            'categoria_id' => $this->categoriaId,
            'isbn' => $this->isbn,
            'editora' => $this->editora,
            'ano_publicacao' => $this->anoPublicacao,
            'paginas' => $this->paginas,
            'preco' => $this->preco,
            'status' => $this->status,
            'quantidade' => $this->quantidade,
            'imagem_capa' => $this->imagemCapa,
        ];
    }
}
