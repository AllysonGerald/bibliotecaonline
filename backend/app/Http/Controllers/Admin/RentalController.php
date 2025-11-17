<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Rentals\CreateRentalAction;
use App\Actions\Rentals\DeleteRentalAction;
use App\Actions\Rentals\UpdateRentalAction;
use App\DTOs\RentalDTO;
use App\Enums\RentalStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRentalRequest;
use App\Http\Requests\Admin\UpdateRentalRequest;
use App\Models\Book;
use App\Models\Rental;
use App\Models\User;
use App\Services\RentalService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RentalController extends Controller
{
    public function __construct(
        private readonly RentalService $rentalService,
        private readonly CreateRentalAction $createRentalAction,
        private readonly UpdateRentalAction $updateRentalAction,
        private readonly DeleteRentalAction $deleteRentalAction,
    ) {
    }

    public function index(Request $request): View
    {
        $rentals = $this->rentalService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
        );

        return view('admin.alugueis.index', compact('rentals'));
    }

    public function create(): View
    {
        $users = User::where('ativo', true)->orderBy('name')->get();
        $books = Book::where('status', \App\Enums\BookStatus::DISPONIVEL)->orderBy('titulo')->get();

        return view('admin.alugueis.create', compact('users', 'books'));
    }

    public function store(StoreRentalRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new RentalDTO(
            usuarioId: $validated['usuario_id'],
            livroId: $validated['livro_id'],
            alugadoEm: Carbon::parse($validated['alugado_em']),
            dataDevolucao: Carbon::parse($validated['data_devolucao']),
            devolvidoEm: isset($validated['devolvido_em']) ? Carbon::parse($validated['devolvido_em']) : null,
            taxaAtraso: (float) ($validated['taxa_atraso'] ?? 0),
            status: RentalStatus::from($validated['status']),
        );

        $this->createRentalAction->execute($dto);

        return redirect()->route('admin.alugueis.index')
            ->with('success', 'Aluguel criado com sucesso!')
        ;
    }

    public function show(Rental $aluguel): View
    {
        $aluguel->load(['user', 'book.author', 'book.category', 'fine']);

        return view('admin.alugueis.show', compact('aluguel'));
    }

    public function edit(Rental $aluguel): View
    {
        $aluguel->load(['user', 'book']);
        $users = User::where('ativo', true)->orderBy('name')->get();
        $books = Book::orderBy('titulo')->get();

        return view('admin.alugueis.edit', compact('aluguel', 'users', 'books'));
    }

    public function update(UpdateRentalRequest $request, Rental $aluguel): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new RentalDTO(
            usuarioId: $validated['usuario_id'],
            livroId: $validated['livro_id'],
            alugadoEm: Carbon::parse($validated['alugado_em']),
            dataDevolucao: Carbon::parse($validated['data_devolucao']),
            devolvidoEm: isset($validated['devolvido_em']) ? Carbon::parse($validated['devolvido_em']) : null,
            taxaAtraso: (float) ($validated['taxa_atraso'] ?? 0),
            status: RentalStatus::from($validated['status']),
        );

        $this->updateRentalAction->execute($aluguel, $dto);

        return redirect()->route('admin.alugueis.index')
            ->with('success', 'Aluguel atualizado com sucesso!')
        ;
    }

    public function destroy(Rental $aluguel): RedirectResponse
    {
        $this->deleteRentalAction->execute($aluguel);

        return redirect()->route('admin.alugueis.index')
            ->with('success', 'Aluguel excluído com sucesso!')
        ;
    }
}
