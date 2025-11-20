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
use App\Models\Reservation;
use App\Services\BookService;
use App\Services\ReservationService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsável pelo gerenciamento de reservas na área administrativa.
 */
class ReservationController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService,
        private readonly UserService $userService,
        private readonly BookService $bookService,
        private readonly CreateReservationAction $createReservationAction,
        private readonly UpdateReservationAction $updateReservationAction,
        private readonly DeleteReservationAction $deleteReservationAction,
    ) {
    }

    /**
     * Exibe o formulário de criação de reserva.
     *
     * @return View Formulário de criação
     */
    public function create(): View
    {
        $users = $this->userService->getAllOrdered();
        $books = $this->bookService->getAllWithAuthorOrdered();
        $statuses = ReservationStatus::cases();

        return view('admin.reservas.create', compact('users', 'books', 'statuses'));
    }

    /**
     * Remove uma reserva do sistema.
     *
     * @param Reservation $reserva Reserva a ser removida
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function destroy(Reservation $reserva): RedirectResponse
    {
        $this->deleteReservationAction->execute($reserva);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva excluída com sucesso!')
        ;
    }

    /**
     * Exibe o formulário de edição de reserva.
     *
     * @param Reservation $reserva Reserva a ser editada
     * @return View Formulário de edição
     */
    public function edit(Reservation $reserva): View
    {
        $reserva->load(['user', 'book']);
        $users = $this->userService->getAllOrdered();
        $books = $this->bookService->getAllWithAuthorOrdered();
        $statuses = ReservationStatus::cases();

        return view('admin.reservas.edit', compact('reserva', 'users', 'books', 'statuses'));
    }

    /**
     * Lista todas as reservas com paginação e filtros.
     *
     * @param Request $request Requisição HTTP com parâmetros de busca
     * @return View Lista de reservas
     */
    public function index(Request $request): View
    {
        $reservations = $this->reservationService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
            userId: $request->filled('usuario_id') ? (int) $request->usuario_id : null,
            bookId: $request->filled('livro_id') ? (int) $request->livro_id : null,
            status: $request->filled('status') ? $request->status : null,
        );

        $users = $this->userService->getAllOrdered();
        $books = $this->bookService->getAllWithAuthorOrdered();
        $statuses = ReservationStatus::cases();

        return view('admin.reservas.index', compact('reservations', 'users', 'books', 'statuses'));
    }

    /**
     * Exibe os detalhes de uma reserva específica.
     *
     * @param Reservation $reserva Reserva a ser exibida
     * @return View Detalhes da reserva
     */
    public function show(Reservation $reserva): View
    {
        $reserva->load(['user', 'book.author', 'book.category']);

        return view('admin.reservas.show', compact('reserva'));
    }

    /**
     * Armazena uma nova reserva no sistema.
     *
     * @param StoreReservationRequest $request Dados validados da reserva
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new ReservationDTO(
            usuarioId: (int) $validated['usuario_id'],
            livroId: (int) $validated['livro_id'],
            reservadoEm: Carbon::parse($validated['reservado_em']),
            expiraEm: Carbon::parse($validated['expira_em']),
            status: ReservationStatus::from($validated['status']),
        );

        $this->createReservationAction->execute($dto);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva criada com sucesso!')
        ;
    }

    /**
     * Atualiza os dados de uma reserva existente.
     *
     * @param UpdateReservationRequest $request Dados validados da reserva
     * @param Reservation $reserva Reserva a ser atualizada
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function update(UpdateReservationRequest $request, Reservation $reserva): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new ReservationDTO(
            usuarioId: (int) $validated['usuario_id'],
            livroId: (int) $validated['livro_id'],
            reservadoEm: Carbon::parse($validated['reservado_em']),
            expiraEm: Carbon::parse($validated['expira_em']),
            status: ReservationStatus::from($validated['status']),
        );

        $this->updateReservationAction->execute($reserva, $dto);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva atualizada com sucesso!')
        ;
    }
}
