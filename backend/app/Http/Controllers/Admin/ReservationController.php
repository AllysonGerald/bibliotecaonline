<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Reservations\CreateReservationAction;
use App\Actions\Reservations\DeleteReservationAction;
use App\Actions\Reservations\UpdateReservationAction;
use App\DTOs\ReservationDTO;
use App\Enums\ReservationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreReservationRequest;
use App\Http\Requests\Admin\UpdateReservationRequest;
use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use App\Services\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService,
        private readonly CreateReservationAction $createReservationAction,
        private readonly UpdateReservationAction $updateReservationAction,
        private readonly DeleteReservationAction $deleteReservationAction,
    ) {
    }

    public function index(Request $request): View
    {
        $reservations = $this->reservationService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
            userId: $request->filled('usuario_id') ? (int) $request->usuario_id : null,
            bookId: $request->filled('livro_id') ? (int) $request->livro_id : null,
            status: $request->filled('status') ? $request->status : null,
        );

        $users = User::orderBy('name')->get();
        $books = Book::orderBy('titulo')->get();
        $statuses = ReservationStatus::cases();

        return view('admin.reservas.index', compact('reservations', 'users', 'books', 'statuses'));
    }

    public function create(): View
    {
        $users = User::orderBy('name')->get();
        $books = Book::orderBy('titulo')->get();
        $statuses = ReservationStatus::cases();

        return view('admin.reservas.create', compact('users', 'books', 'statuses'));
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new ReservationDTO(
            usuarioId: $validated['usuario_id'],
            livroId: $validated['livro_id'],
            reservadoEm: Carbon::parse($validated['reservado_em']),
            expiraEm: Carbon::parse($validated['expira_em']),
            status: ReservationStatus::from($validated['status']),
        );

        $this->createReservationAction->execute($dto);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva criada com sucesso!')
        ;
    }

    public function show(Reservation $reserva): View
    {
        $reserva->load(['user', 'book.author', 'book.category']);

        return view('admin.reservas.show', compact('reserva'));
    }

    public function edit(Reservation $reserva): View
    {
        $reserva->load(['user', 'book']);
        $users = User::orderBy('name')->get();
        $books = Book::orderBy('titulo')->get();
        $statuses = ReservationStatus::cases();

        return view('admin.reservas.edit', compact('reserva', 'users', 'books', 'statuses'));
    }

    public function update(UpdateReservationRequest $request, Reservation $reserva): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new ReservationDTO(
            usuarioId: $validated['usuario_id'],
            livroId: $validated['livro_id'],
            reservadoEm: Carbon::parse($validated['reservado_em']),
            expiraEm: Carbon::parse($validated['expira_em']),
            status: ReservationStatus::from($validated['status']),
        );

        $this->updateReservationAction->execute($reserva, $dto);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva atualizada com sucesso!')
        ;
    }

    public function destroy(Reservation $reserva): RedirectResponse
    {
        $this->deleteReservationAction->execute($reserva);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva excluída com sucesso!')
        ;
    }
}
