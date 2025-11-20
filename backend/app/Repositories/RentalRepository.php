<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository responsável pelo acesso aos dados de aluguéis.
 */
class RentalRepository implements RentalRepositoryInterface
{
    /**
     * Cria um novo registro de aluguel.
     *
     * @param array<string, mixed> $data Dados do aluguel
     * @return Rental Aluguel criado
     */
    public function create(array $data): Rental
    {
        return Rental::create($data);
    }

    /**
     * Remove um aluguel do banco de dados.
     *
     * @param Rental $rental Aluguel a ser removido
     * @return bool True se removido com sucesso
     */
    public function delete(Rental $rental): bool
    {
        return (bool) $rental->delete();
    }

    /**
     * Retorna aluguéis ativos com relacionamentos carregados.
     *
     * @return Collection Aluguéis ativos
     */
    public function findActive(): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->active()
            ->latest('alugado_em')
            ->get()
        ;
    }

    /**
     * Retorna todos os aluguéis com relacionamentos carregados.
     *
     * @return Collection Todos os aluguéis
     */
    public function findAll(): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])->get();
    }

    /**
     * Retorna aluguéis paginados com filtro opcional de busca.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (nome/email do usuário ou título do livro)
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator {
        $query = Rental::with(['user', 'book.author', 'book.category']);

        if ($search !== null) {
            $query->whereHas('user', static function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                ;
            })
                ->orWhereHas('book', static function ($q) use ($search): void {
                    $q->where('titulo', 'like', "%{$search}%");
                })
            ;
        }

        return $query->latest('alugado_em')->paginate($perPage);
    }

    /**
     * Busca aluguéis por livro.
     *
     * @param int $bookId ID do livro
     * @return Collection Aluguéis do livro
     */
    public function findByBook(int $bookId): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->where('livro_id', $bookId)
            ->latest('alugado_em')
            ->get()
        ;
    }

    /**
     * Busca um aluguel por ID com relacionamentos carregados.
     *
     * @param int $id ID do aluguel
     * @return Rental|null Aluguel encontrado ou null
     */
    public function findById(int $id): ?Rental
    {
        return Rental::with(['user', 'book.author', 'book.category', 'fine'])->find($id);
    }

    /**
     * Busca aluguéis por usuário.
     *
     * @param int $userId ID do usuário
     * @return Collection Aluguéis do usuário
     */
    public function findByUser(int $userId): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->where('usuario_id', $userId)
            ->latest('alugado_em')
            ->get()
        ;
    }

    /**
     * Retorna aluguéis vencidos (atrasados).
     *
     * @return Collection Aluguéis vencidos
     */
    public function findOverdue(): Collection
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->overdue()
            ->latest('data_devolucao')
            ->get()
        ;
    }

    /**
     * Retorna aluguéis paginados sem filtros.
     *
     * @param int $perPage Quantidade de itens por página
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Rental::with(['user', 'book.author', 'book.category'])
            ->latest('alugado_em')
            ->paginate($perPage)
        ;
    }

    /**
     * Retorna a quantidade de aluguéis ativos no sistema.
     *
     * @return int Quantidade de aluguéis ativos
     */
    public function getActiveCount(): int
    {
        return Rental::where('status', \App\Enums\RentalStatus::ATIVO)->count();
    }

    /**
     * Busca aluguéis por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Aluguéis encontrados
     */
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

    /**
     * Atualiza os dados de um aluguel.
     *
     * @param Rental $rental Aluguel a ser atualizado
     * @param array<string, mixed> $data Novos dados
     * @return bool True se atualizado com sucesso
     */
    public function update(Rental $rental, array $data): bool
    {
        return $rental->update($data);
    }
}
