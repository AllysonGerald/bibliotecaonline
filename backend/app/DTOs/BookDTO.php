<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\BookStatus;

/**
 * DTO (Data Transfer Object) para transferência de dados de livro.
 */
final readonly class BookDTO
{
    /**
     * @param string $titulo Título do livro
     * @param string $descricao Descrição do livro
     * @param int|null $autorId ID do autor (null se desconhecido)
     * @param int $categoriaId ID da categoria
     * @param string $isbn ISBN do livro
     * @param string $editora Editora do livro
     * @param int $anoPublicacao Ano de publicação
     * @param int $paginas Quantidade de páginas
     * @param float $preco Preço do livro
     * @param BookStatus $status Status do livro
     * @param int $quantidade Quantidade de exemplares disponíveis
     * @param string|null $imagemCapa Caminho da imagem de capa
     * @param array<int>|null $tags IDs das tags associadas ao livro
     */
    public function __construct(
        public string $titulo,
        public string $descricao,
        public ?int $autorId,
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

    /**
     * Converte o DTO para array associativo.
     *
     * @return array<string, mixed> Dados do livro em formato array
     */
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
