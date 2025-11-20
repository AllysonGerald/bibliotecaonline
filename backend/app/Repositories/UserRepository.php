<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository responsável pelo acesso aos dados de usuários.
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Cria um novo registro de usuário.
     * Criptografa a senha antes de salvar.
     *
     * @param array<string, mixed> $data Dados do usuário
     * @return User Usuário criado
     */
    public function create(array $data): User
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        return User::create($data);
    }

    /**
     * Remove um usuário do banco de dados.
     *
     * @param User $user Usuário a ser removido
     * @return bool True se removido com sucesso
     */
    public function delete(User $user): bool
    {
        return (bool) $user->delete();
    }

    /**
     * Retorna usuários ativos com relacionamentos carregados.
     *
     * @return Collection Usuários ativos
     */
    public function findActive(): Collection
    {
        return User::with(['rentals', 'reservations'])
            ->where('ativo', true)
            ->latest()
            ->get()
        ;
    }

    /**
     * Retorna todos os usuários com relacionamentos carregados.
     *
     * @return Collection Todos os usuários
     */
    public function findAll(): Collection
    {
        return User::with(['rentals', 'reservations'])->get();
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
    public function findAllPaginated(
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

    /**
     * Busca um usuário por email.
     *
     * @param string $email Email do usuário
     * @return User|null Usuário encontrado ou null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Busca um usuário por ID com todos os relacionamentos.
     *
     * @param int $id ID do usuário
     * @return User|null Usuário encontrado ou null
     */
    public function findById(int $id): ?User
    {
        return User::with(['rentals', 'reservations', 'reviews', 'fines', 'wishlists'])->find($id);
    }

    /**
     * Busca usuários por papel (role).
     *
     * @param string $role Papel do usuário
     * @return Collection Usuários com o papel especificado
     */
    public function findByRole(string $role): Collection
    {
        return User::with(['rentals', 'reservations'])
            ->where('papel', $role)
            ->latest()
            ->get()
        ;
    }

    /**
     * Retorna usuários inativos com relacionamentos carregados.
     *
     * @return Collection Usuários inativos
     */
    public function findInactive(): Collection
    {
        return User::with(['rentals', 'reservations'])
            ->where('ativo', false)
            ->latest()
            ->get()
        ;
    }

    /**
     * Retorna usuários paginados sem filtros.
     *
     * @param int $perPage Quantidade de itens por página
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return User::with(['rentals', 'reservations'])
            ->latest()
            ->paginate($perPage)
        ;
    }

    /**
     * Retorna a quantidade total de usuários no sistema.
     *
     * @return int Quantidade total de usuários
     */
    public function getTotalCount(): int
    {
        return User::count();
    }

    /**
     * Busca usuários por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Usuários encontrados
     */
    public function search(string $term): Collection
    {
        return User::with(['rentals', 'reservations'])
            ->where('name', 'like', "%{$term}%")
            ->orWhere('email', 'like', "%{$term}%")
            ->latest()
            ->get()
        ;
    }

    /**
     * Atualiza os dados de um usuário.
     * Criptografa a senha se fornecida e não estiver vazia.
     *
     * @param User $user Usuário a ser atualizado
     * @param array<string, mixed> $data Novos dados
     * @return bool True se atualizado com sucesso
     */
    public function update(User $user, array $data): bool
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        return $user->update($data);
    }
}
