<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function delete(Category $category): bool
    {
        return (bool) $category->delete();
    }

    public function findAll(): Collection
    {
        return Category::with('books')->get();
    }

    public function findById(int $id): ?Category
    {
        return Category::with('books')->find($id);
    }

    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Category::with('books')
            ->latest()
            ->paginate($perPage)
        ;
    }

    public function search(string $term): Collection
    {
        return Category::with('books')
            ->where('nome', 'like', "%{$term}%")
            ->orWhere('descricao', 'like', "%{$term}%")
            ->get()
        ;
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }
}
