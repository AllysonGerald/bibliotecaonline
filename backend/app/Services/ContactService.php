<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ContactDTO;
use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ContactService
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository,
    ) {
    }

    public function create(ContactDTO $dto): Contact
    {
        return $this->contactRepository->create($dto->toArray());
    }

    public function delete(Contact $contact): bool
    {
        return $this->contactRepository->delete($contact);
    }

    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator {
        $query = Contact::query();

        if ($search !== null) {
            $query->where('nome', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('assunto', 'like', "%{$search}%")
                ->orWhere('mensagem', 'like', "%{$search}%")
            ;
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById(int $id): ?Contact
    {
        return $this->contactRepository->findById($id);
    }

    public function markAsRead(Contact $contact): void
    {
        $contact->markAsRead();
    }

    public function search(string $term): Collection
    {
        return $this->contactRepository->search($term);
    }
}
