<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Reservation;
use App\Repositories\Contracts\ReservationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function create(array $data): Reservation
    {
        return Reservation::create($data);
    }

    public function delete(Reservation $reservation): bool
    {
        return (bool) $reservation->delete();
    }

    public function findActive(): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->active()
            ->latest('reservado_em')
            ->get()
        ;
    }

    public function findAll(): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])->get();
    }

    public function findByBook(int $bookId): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->where('livro_id', $bookId)
            ->latest('reservado_em')
            ->get()
        ;
    }

    public function findById(int $id): ?Reservation
    {
        return Reservation::with(['user', 'book.author', 'book.category'])->find($id);
    }

    public function findByUser(int $userId): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->where('usuario_id', $userId)
            ->latest('reservado_em')
            ->get()
        ;
    }

    public function findExpired(): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->expired()
            ->latest('expira_em')
            ->get()
        ;
    }

    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->latest('reservado_em')
            ->paginate($perPage)
        ;
    }

    public function search(string $term): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->whereHas('user', static function ($query) use ($term): void {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                ;
            })
            ->orWhereHas('book', static function ($query) use ($term): void {
                $query->where('titulo', 'like', "%{$term}%");
            })
            ->latest('reservado_em')
            ->get()
        ;
    }

    public function update(Reservation $reservation, array $data): bool
    {
        return $reservation->update($data);
    }
}
