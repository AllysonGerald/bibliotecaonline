<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RentalRepository implements RentalRepositoryInterface
{
    public function create(array $data): Rental
    {
        return Rental::create($data);
    }

    public function delete(Rental $rental): bool
    {
        return (bool) $rental->delete();
    }

    public function findActive(): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->active()
            ->latest('alugado_em')
            ->get()
        ;
    }

    public function findAll(): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])->get();
    }

    public function findByBook(int $bookId): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->where('livro_id', $bookId)
            ->latest('alugado_em')
            ->get()
        ;
    }

    public function findById(int $id): ?Rental
    {
        return Rental::with(['user', 'book.author', 'book.category', 'fine'])->find($id);
    }

    public function findByUser(int $userId): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->where('usuario_id', $userId)
            ->latest('alugado_em')
            ->get()
        ;
    }

    public function findOverdue(): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->overdue()
            ->latest('data_devolucao')
            ->get()
        ;
    }

    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->latest('alugado_em')
            ->paginate($perPage)
        ;
    }

    public function search(string $term): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->whereHas('user', static function ($query) use ($term): void {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                ;
            })
            ->orWhereHas('book', static function ($query) use ($term): void {
                $query->where('titulo', 'like', "%{$term}%");
            })
            ->latest('alugado_em')
            ->get()
        ;
    }

    public function update(Rental $rental, array $data): bool
    {
        return $rental->update($data);
    }
}
