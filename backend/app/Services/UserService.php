<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

/**
 * Service responsável pela lógica de negócio relacionada a usuários.
 */
class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * Cria um novo usuário no sistema.
     *
     * @param UserDTO $dto Dados do usuário a ser criado
     * @return User Usuário criado
     */
    public function create(UserDTO $dto): User
    {
        return $this->userRepository->create($dto->toArray());
    }

    /**
     * Remove um usuário do sistema.
     *
     * @param User $user Usuário a ser removido
     * @return bool True se removido com sucesso
     */
    public function delete(User $user): bool
    {
        return $this->userRepository->delete($user);
    }

    /**
     * Retorna usuários ativos.
     *
     * @return Collection Usuários ativos
     */
    public function getActive(): Collection
    {
        return $this->userRepository->findActive();
    }

    /**
     * Retorna todos os usuários ordenados por nome.
     * Utilizado para preencher dropdowns em formulários.
     *
     * @param bool|null $onlyActive Se deve retornar apenas usuários ativos
     * @return Collection Todos os usuários ordenados
     */
    public function getAllOrdered(?bool $onlyActive = null): Collection
    {
        if ($onlyActive === true) {
            return $this->userRepository->findActive()->sortBy('name')->values();
        }

        return $this->userRepository->findAll()->sortBy('name')->values();
    }

    /**
     * Retorna usuários paginados com filtros opcionais.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (nome ou email)
     * @param string|null $role Papel do usuário para filtrar
     * @param bool|null $ativo Status ativo/inativo para filtrar
     * @return LengthAwarePaginator Resultados paginados
     */
    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
        ?string $role = null,
        ?bool $ativo = null,
    ): LengthAwarePaginator {
        return $this->userRepository->findAllPaginated(
            perPage: $perPage,
            search: $search,
            role: $role,
            ativo: $ativo,
        );
    }

    /**
     * Busca um usuário por email.
     *
     * @param string $email Email do usuário
     * @return User|null Usuário encontrado ou null
     */
    public function getByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Busca um usuário por ID.
     *
     * @param int $id ID do usuário
     * @return User|null Usuário encontrado ou null
     */
    public function getById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Busca usuários por papel (role).
     *
     * @param string $role Papel do usuário
     * @return Collection Usuários com o papel especificado
     */
    public function getByRole(string $role): Collection
    {
        return $this->userRepository->findByRole($role);
    }

    /**
     * Retorna usuários inativos.
     *
     * @return Collection Usuários inativos
     */
    public function getInactive(): Collection
    {
        return $this->userRepository->findInactive();
    }

    /**
     * Retorna a quantidade total de usuários no sistema.
     *
     * @return int Quantidade total de usuários
     */
    public function getTotalCount(): int
    {
        return $this->userRepository->getTotalCount();
    }

    /**
     * Busca usuários por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Usuários encontrados
     */
    public function search(string $term): Collection
    {
        return $this->userRepository->search($term);
    }

    /**
     * Atualiza os dados de um usuário existente.
     *
     * @param User $user Usuário a ser atualizado
     * @param UserDTO $dto Novos dados do usuário
     * @return User Usuário atualizado com relacionamentos carregados
     * @throws RuntimeException Se a atualização falhar
     */
    public function update(User $user, UserDTO $dto): User
    {
        $updated = $this->userRepository->update($user, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar o usuário.');
        }

        return $user->fresh(['rentals', 'reservations', 'reviews', 'fines', 'wishlists']) ?? $user;
    }
}
