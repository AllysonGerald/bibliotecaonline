<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Rentals\CreateRentalAction;
use App\DTOs\RentalDTO;
use App\Enums\RentalStatus;
use App\Http\Requests\StoreUserRentalRequest;
use App\Models\Book;
use App\Services\RentalService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserRentalController extends Controller
{
    public function __construct(
        private readonly RentalService $rentalService,
        private readonly CreateRentalAction $createRentalAction,
    ) {
    }

    public function index(Request $request): View
    {
        $user = auth()->user();

        $rentals = $this->rentalService->getByUser($user->id);

        // Filtrar por status se fornecido
        if ($request->filled('status')) {
            $rentals = $rentals->filter(fn ($rental) => $rental->status->value === $request->status);
        }

        // Separar em grupos
        $activeRentals = $rentals->where('status', RentalStatus::ATIVO)->values();
        $returnedRentals = $rentals->where('status', RentalStatus::DEVOLVIDO)->values();
        $overdueRentals = $rentals->where('status', RentalStatus::ATRASADO)->values();

        // Se houver filtro de status, usar apenas o grupo correspondente
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === RentalStatus::ATIVO->value) {
                $rentals = $activeRentals;
            } elseif ($status === RentalStatus::DEVOLVIDO->value) {
                $rentals = $returnedRentals;
            } elseif ($status === RentalStatus::ATRASADO->value) {
                $rentals = $overdueRentals;
            }
        }

        return view('user.alugueis', compact('rentals', 'activeRentals', 'returnedRentals', 'overdueRentals'));
    }

    public function store(StoreUserRentalRequest $request, Book $livro): RedirectResponse
    {
        $user = auth()->user();

        // Recarregar o livro para garantir que temos os dados atualizados
        $livro->refresh();

        // Verificar se o livro está disponível
        if (!$livro->isAvailable()) {
            return redirect()->back()
                ->with('error', 'Este livro não está disponível para aluguel.')
            ;
        }

        // Verificar se o usuário já tem um aluguel ativo deste livro
        $existingRental = $this->rentalService->getByUser($user->id)
            ->where('livro_id', $livro->id)
            ->where('status', RentalStatus::ATIVO)
            ->first()
        ;

        if ($existingRental) {
            return redirect()->back()
                ->with('error', 'Você já possui um aluguel ativo deste livro.')
            ;
        }

        // Calcular quantos exemplares estão alugados ANTES de criar o novo aluguel
        $alugueisAtivos = $livro->rentals()
            ->where('status', RentalStatus::ATIVO)
            ->count()
        ;

        // Criar o aluguel (prazo padrão: 14 dias)
        $alugadoEm = now();
        $dataDevolucao = $alugadoEm->copy()->addDays(14);

        $dto = new RentalDTO(
            usuarioId: $user->id,
            livroId: $livro->id,
            alugadoEm: $alugadoEm,
            dataDevolucao: $dataDevolucao,
            devolvidoEm: null,
            taxaAtraso: 0.0,
            status: RentalStatus::ATIVO,
        );

        $this->createRentalAction->execute($dto);

        // Atualizar a quantidade do livro (decrementar)
        if ($livro->quantidade !== null && $livro->quantidade > 0) {
            $livro->decrement('quantidade');
            // Recarregar para ter o valor atualizado
            $livro->refresh();
        }

        // Verificar se ainda há exemplares disponíveis após este aluguel
        // Se quantidade chegou a 0, não há mais exemplares disponíveis
        if ($livro->quantidade !== null && $livro->quantidade <= 0) {
            $livro->update(['status' => \App\Enums\BookStatus::ALUGADO]);
        }

        return redirect()->route('meus-alugueis')
            ->with('success', 'Livro alugado com sucesso! Data de devolução: '.$dataDevolucao->format('d/m/Y'))
        ;
    }
}
