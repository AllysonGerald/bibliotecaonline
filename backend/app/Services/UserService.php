<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function create(UserDTO $dto): User
    {
        return $this->userRepository->create($dto->toArray());
    }

    public function delete(User $user): bool
    {
        return $this->userRepository->delete($user);
    }

    public function getActive(): Collection
    {
        return $this->userRepository->findActive();
    }

    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
        ?string $role = null,
        ?bool $ativo = null,
    ): LengthAwarePaginator {
        $query = User::with(['rentals', 'reservations']);

        if ($search !== null) {
            $query->where(static function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                ;
            });
        }

        if ($role !== null) {
            $query->where('papel', $role);
        }

        if ($ativo !== null) {
            $query->where('ativo', $ativo);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function getById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function getByRole(string $role): Collection
    {
        return $this->userRepository->findByRole($role);
    }

    public function getInactive(): Collection
    {
        return $this->userRepository->findInactive();
    }

    public function search(string $term): Collection
    {
        return $this->userRepository->search($term);
    }

    public function update(User $user, UserDTO $dto): User
    {
        $updated = $this->userRepository->update($user, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar o usuário.');
        }

        return $user->fresh(['rentals', 'reservations', 'reviews', 'fines', 'wishlists']) ?? $user;
    }
}
