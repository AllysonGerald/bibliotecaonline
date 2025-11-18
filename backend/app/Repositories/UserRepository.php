<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function findAll(): Collection
    {
        return User::with(['rentals', 'reservations'])->get();
    }

    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return User::with(['rentals', 'reservations'])
            ->latest()
            ->paginate($perPage)
        ;
    }

    public function findById(int $id): ?User
    {
        return User::with(['rentals', 'reservations', 'reviews', 'fines', 'wishlists'])->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function search(string $term): Collection
    {
        return User::with(['rentals', 'reservations'])
            ->where('name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->latest()
            ->get()
        ;
    }

    public function findActive(): Collection
    {
        return User::with(['rentals', 'reservations'])
            ->where('ativo', true)
            ->latest()
            ->get()
        ;
    }

    public function findInactive(): Collection
    {
        return User::with(['rentals', 'reservations'])
            ->where('ativo', false)
            ->latest()
            ->get()
        ;
    }

    public function findByRole(string $role): Collection
    {
        return User::with(['rentals', 'reservations'])
            ->where('papel', $role)
            ->latest()
            ->get()
        ;
    }

    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }
}
