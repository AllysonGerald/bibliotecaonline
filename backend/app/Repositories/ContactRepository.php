<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ContactRepository implements ContactRepositoryInterface
{
    public function create(array $data): Contact
    {
        return Contact::create($data);
    }

    public function delete(Contact $contact): bool
    {
        return (bool) $contact->delete();
    }

    public function findAll(): Collection
    {
        return Contact::latest()->get();
    }

    public function findById(int $id): ?Contact
    {
        return Contact::find($id);
    }

    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Contact::latest()->paginate($perPage);
    }

    public function search(string $term): Collection
    {
        return Contact::where('nome', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->orWhere('assunto', 'like', "%{$term}%")
            ->orWhere('mensagem', 'like', "%{$term}%")
            ->latest()
            ->get()
        ;
    }
}
