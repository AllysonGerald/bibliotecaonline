<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\RentalDTO;
use App\Models\Fine;
use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

/**
 * Service responsável pela lógica de negócio relacionada a aluguéis.
 */
class RentalService
{
    public function __construct(
        private readonly RentalRepositoryInterface $rentalRepository,
    ) {
    }

    /**
     * Cria um novo aluguel no sistema.
     *
     * @param RentalDTO $dto Dados do aluguel a ser criado
     * @return Rental Aluguel criado
     */
    public function create(RentalDTO $dto): Rental
    {
        $rental = $this->rentalRepository->create($dto->toArray());

        // Criar multa se houver taxa de atraso
        if ($dto->taxaAtraso > 0) {
            $this->createOrUpdateFine($rental, $dto->taxaAtraso);
        }

        return $rental->fresh(['user', 'book.author', 'book.category', 'fine']) ?? $rental;
    }

    /**
     * Remove um aluguel do sistema.
     *
     * @param Rental $rental Aluguel a ser removido
     * @return bool True se removido com sucesso
     */
    public function delete(Rental $rental): bool
    {
        return $this->rentalRepository->delete($rental);
    }

    /**
     * Retorna aluguéis ativos.
     *
     * @return Collection Aluguéis ativos
     */
    public function getActive(): Collection
    {
        return $this->rentalRepository->findActive();
    }

    /**
     * Retorna a quantidade de aluguéis ativos no sistema.
     *
     * @return int Quantidade de aluguéis ativos
     */
    public function getActiveCount(): int
    {
        return $this->rentalRepository->getActiveCount();
    }

    /**
     * Retorna aluguéis paginados com filtro opcional de busca.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (nome/email do usuário ou título do livro)
     * @return LengthAwarePaginator Resultados paginados
     */
    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator {
        return $this->rentalRepository->findAllPaginated(
            perPage: $perPage,
            search: $search,
        );
    }

    /**
     * Busca aluguéis por livro.
     *
     * @param int $bookId ID do livro
     * @return Collection Aluguéis do livro
     */
    public function getByBook(int $bookId): Collection
    {
        return $this->rentalRepository->findByBook($bookId);
    }

    /**
     * Busca um aluguel por ID.
     *
     * @param int $id ID do aluguel
     * @return Rental|null Aluguel encontrado ou null
     */
    public function getById(int $id): ?Rental
    {
        return $this->rentalRepository->findById($id);
    }

    /**
     * Busca aluguéis por usuário.
     *
     * @param int $userId ID do usuário
     * @return Collection Aluguéis do usuário
     */
    public function getByUser(int $userId): Collection
    {
        return $this->rentalRepository->findByUser($userId);
    }

    /**
     * Retorna aluguéis vencidos (atrasados).
     *
     * @return Collection Aluguéis vencidos
     */
    public function getOverdue(): Collection
    {
        return $this->rentalRepository->findOverdue();
    }

    /**
     * Busca aluguéis por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Aluguéis encontrados
     */
    public function search(string $term): Collection
    {
        return $this->rentalRepository->search($term);
    }

    /**
     * Atualiza os dados de um aluguel existente.
     *
     * @param Rental $rental Aluguel a ser atualizado
     * @param RentalDTO $dto Novos dados do aluguel
     * @return Rental Aluguel atualizado com relacionamentos carregados
     * @throws RuntimeException Se a atualização falhar
     */
    public function update(Rental $rental, RentalDTO $dto): Rental
    {
        $updated = $this->rentalRepository->update($rental, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar o aluguel.');
        }

        // Recarregar o aluguel para ter os dados atualizados
        $rental->refresh();

        // Calcular multa automaticamente se o livro foi devolvido com atraso
        // Prioridade: se taxa_atraso foi informada manualmente, usar ela; senão, calcular automaticamente
        if ($dto->taxaAtraso > 0) {
            // Se o admin informou manualmente a taxa, usar ela
            $this->createOrUpdateFine($rental, $dto->taxaAtraso);
        } elseif ($dto->devolvidoEm !== null && $dto->devolvidoEm > $dto->dataDevolucao) {
            // Se não foi informada manualmente, calcular automaticamente baseado no atraso
            $calculatedFine = $this->calculateFineForOverdue($dto->dataDevolucao, $dto->devolvidoEm);
            if ($calculatedFine > 0) {
                $this->createOrUpdateFine($rental, $calculatedFine);
            }
        }

        return $rental->fresh(['user', 'book.author', 'book.category', 'fine']) ?? $rental;
    }

    /**
     * Calcula o valor da multa baseado nos dias de atraso.
     *
     * @param Carbon $dataDevolucao Data prevista para devolução
     * @param Carbon $devolvidoEm Data real da devolução
     * @return float Valor da multa calculado
     */
    private function calculateFineForOverdue(Carbon $dataDevolucao, Carbon $devolvidoEm): float
    {
        $daysOverdue = (int) $dataDevolucao->diffInDays($devolvidoEm);
        $finePerDay = (float) config('library.fine_per_day', 5.00);

        return $daysOverdue * $finePerDay;
    }

    /**
     * Cria ou atualiza uma multa para o aluguel.
     *
     * @param Rental $rental Aluguel relacionado
     * @param float $valor Valor da multa
     */
    private function createOrUpdateFine(Rental $rental, float $valor): void
    {
        // Recarregar o relacionamento fine para garantir que temos os dados atualizados
        $rental->refresh();
        $rental->load('fine');
        $fine = $rental->fine;

        if ($fine) {
            // Atualizar multa existente
            $fine->update([
                'valor' => $valor,
                'usuario_id' => $rental->usuario_id, // Garantir que usuario_id está preenchido
            ]);
        } else {
            // Criar nova multa
            Fine::create([
                'aluguel_id' => $rental->id,
                'usuario_id' => $rental->usuario_id,
                'valor' => $valor,
                'paga' => false,
            ]);
        }
    }
}
