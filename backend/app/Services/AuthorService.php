<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\AuthorDTO;
use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

/**
 * Service responsável pela lógica de negócio relacionada a autores.
 */
class AuthorService
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository,
    ) {
    }

    /**
     * Cria um novo autor no sistema.
     *
     * @param AuthorDTO $dto Dados do autor a ser criado
     * @return Author Autor criado
     */
    public function create(AuthorDTO $dto): Author
    {
        return $this->authorRepository->create($dto->toArray());
    }

    /**
     * Remove um autor do sistema.
     *
     * @param Author $author Autor a ser removido
     * @return bool True se removido com sucesso
     */
    public function delete(Author $author): bool
    {
        return $this->authorRepository->delete($author);
    }

    /**
     * Retorna todos os autores ordenados por nome.
     * Utilizado para preencher dropdowns em formulários.
     *
     * @return Collection Todos os autores ordenados
     */
    public function getAllOrdered(): Collection
    {
        return $this->authorRepository->findAll()->sortBy('nome')->values();
    }

    /**
     * Retorna autores paginados com filtro opcional de busca.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (nome ou biografia)
     * @return LengthAwarePaginator Resultados paginados
     */
    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator {
        return $this->authorRepository->findAllPaginated(
            perPage: $perPage,
            search: $search,
        );
    }

    /**
     * Busca um autor por ID.
     *
     * @param int $id ID do autor
     * @return Author|null Autor encontrado ou null
     */
    public function getById(int $id): ?Author
    {
        return $this->authorRepository->findById($id);
    }

    /**
     * Busca autores por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Autores encontrados
     */
    public function search(string $term): Collection
    {
        return $this->authorRepository->search($term);
    }

    /**
     * Atualiza os dados de um autor existente.
     *
     * @param Author $author Autor a ser atualizado
     * @param AuthorDTO $dto Novos dados do autor
     * @return Author Autor atualizado com relacionamentos carregados
     * @throws RuntimeException Se a atualização falhar
     */
    public function update(Author $author, AuthorDTO $dto): Author
    {
        $updated = $this->authorRepository->update($author, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar o autor.');
        }

        return $author->fresh('books') ?? $author;
    }
}
