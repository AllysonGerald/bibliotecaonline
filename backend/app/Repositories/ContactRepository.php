<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository responsável pelo acesso aos dados de mensagens de contato.
 */
class ContactRepository implements ContactRepositoryInterface
{
    /**
     * Cria um novo registro de mensagem de contato.
     *
     * @param array<string, mixed> $data Dados da mensagem
     * @return Contact Mensagem criada
     */
    public function create(array $data): Contact
    {
        return Contact::create($data);
    }

    /**
     * Remove uma mensagem de contato do banco de dados.
     *
     * @param Contact $contact Mensagem a ser removida
     * @return bool True se removida com sucesso
     */
    public function delete(Contact $contact): bool
    {
        return (bool) $contact->delete();
    }

    /**
     * Retorna todas as mensagens de contato ordenadas por data.
     *
     * @return Collection Todas as mensagens
     */
    public function findAll(): Collection
    {
        return Contact::latest()->get();
    }

    /**
     * Retorna mensagens de contato paginadas com filtro opcional de busca.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (nome, email, assunto ou mensagem)
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findAllPaginated(
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

    /**
     * Busca uma mensagem de contato por ID.
     *
     * @param int $id ID da mensagem
     * @return Contact|null Mensagem encontrada ou null
     */
    public function findById(int $id): ?Contact
    {
        return Contact::find($id);
    }

    /**
     * Retorna mensagens de contato paginadas sem filtros.
     *
     * @param int $perPage Quantidade de itens por página
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Contact::latest()->paginate($perPage);
    }

    /**
     * Retorna a quantidade de mensagens não lidas no sistema.
     *
     * @return int Quantidade de mensagens não lidas
     */
    public function getUnreadCount(): int
    {
        return Contact::where('lido', false)->count();
    }

    /**
     * Busca mensagens de contato por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Mensagens encontradas
     */
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
