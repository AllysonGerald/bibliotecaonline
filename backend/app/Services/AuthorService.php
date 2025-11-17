<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\AuthorDTO;
use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class AuthorService
{
    public function __construct(
        private readonly AuthorRepositoryInterface $authorRepository,
    ) {
    }

    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator {
        $query = Author::with('books');

        if ($search !== null) {
            $query->where('nome', 'like', "%{$search}%")
                ->orWhere('biografia', 'like', "%{$search}%")
            ;
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById(int $id): ?Author
    {
        return $this->authorRepository->findById($id);
    }

    public function search(string $term): Collection
    {
        return $this->authorRepository->search($term);
    }

    public function create(AuthorDTO $dto): Author
    {
        return $this->authorRepository->create($dto->toArray());
    }

    public function update(Author $author, AuthorDTO $dto): Author
    {
        $updated = $this->authorRepository->update($author, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar o autor.');
        }

        return $author->fresh('books') ?? $author;
    }

    public function delete(Author $author): bool
    {
        return $this->authorRepository->delete($author);
    }
}
