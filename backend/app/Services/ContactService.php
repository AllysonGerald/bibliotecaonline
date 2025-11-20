<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ContactDTO;
use App\Models\Contact;
use App\Repositories\Contracts\ContactRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service responsável pela lógica de negócio relacionada a mensagens de contato.
 */
class ContactService
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository,
    ) {
    }

    /**
     * Cria uma nova mensagem de contato no sistema.
     *
     * @param ContactDTO $dto Dados da mensagem a ser criada
     * @return Contact Mensagem criada
     */
    public function create(ContactDTO $dto): Contact
    {
        return $this->contactRepository->create($dto->toArray());
    }

    /**
     * Remove uma mensagem de contato do sistema.
     *
     * @param Contact $contact Mensagem a ser removida
     * @return bool True se removida com sucesso
     */
    public function delete(Contact $contact): bool
    {
        return $this->contactRepository->delete($contact);
    }

    /**
     * Retorna mensagens de contato paginadas com filtro opcional de busca.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (nome, email, assunto ou mensagem)
     * @return LengthAwarePaginator Resultados paginados
     */
    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator {
        return $this->contactRepository->findAllPaginated(
            perPage: $perPage,
            search: $search,
        );
    }

    /**
     * Busca uma mensagem de contato por ID.
     *
     * @param int $id ID da mensagem
     * @return Contact|null Mensagem encontrada ou null
     */
    public function getById(int $id): ?Contact
    {
        return $this->contactRepository->findById($id);
    }

    /**
     * Retorna a quantidade de mensagens não lidas.
     *
     * @return int Quantidade de mensagens não lidas
     */
    public function getUnreadCount(): int
    {
        return $this->contactRepository->getUnreadCount();
    }

    /**
     * Marca uma mensagem de contato como lida.
     *
     * @param Contact $contact Mensagem a ser marcada como lida
     */
    public function markAsRead(Contact $contact): void
    {
        $contact->markAsRead();
    }

    /**
     * Busca mensagens de contato por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Mensagens encontradas
     */
    public function search(string $term): Collection
    {
        return $this->contactRepository->search($term);
    }
}
