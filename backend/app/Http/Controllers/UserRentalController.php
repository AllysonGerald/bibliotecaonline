<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\RentalStatus;
use App\Services\RentalService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserRentalController extends Controller
{
    public function __construct(
        private readonly RentalService $rentalService,
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
}

