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
use App\Models\Rental;
use App\Services\BookService;
use App\Services\RentalService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsável pelo gerenciamento de aluguéis na área administrativa.
 */
class RentalController extends Controller
{
    public function __construct(
        private readonly RentalService $rentalService,
        private readonly UserService $userService,
        private readonly BookService $bookService,
        private readonly CreateRentalAction $createRentalAction,
        private readonly UpdateRentalAction $updateRentalAction,
        private readonly DeleteRentalAction $deleteRentalAction,
    ) {
    }

    /**
     * Exibe o formulário de criação de aluguel.
     *
     * @return View Formulário de criação
     */
    public function create(): View
    {
        $users = $this->userService->getAllOrdered(onlyActive: true);
        $books = $this->bookService->getAllWithAuthorOrdered();

        return view('admin.alugueis.create', compact('users', 'books'));
    }

    /**
     * Remove um aluguel do sistema.
     *
     * @param Rental $aluguel Aluguel a ser removido
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function destroy(Rental $aluguel): RedirectResponse
    {
        $this->deleteRentalAction->execute($aluguel);

        return redirect()->route('admin.alugueis.index')
            ->with('success', 'Aluguel excluído com sucesso!')
        ;
    }

    /**
     * Exibe o formulário de edição de aluguel.
     *
     * @param Rental $aluguel Aluguel a ser editado
     * @return View Formulário de edição
     */
    public function edit(Rental $aluguel): View
    {
        $aluguel->load(['user', 'book']);
        $users = $this->userService->getAllOrdered(onlyActive: true);
        $books = $this->bookService->getAllWithAuthorOrdered();

        return view('admin.alugueis.edit', compact('aluguel', 'users', 'books'));
    }

    /**
     * Lista todos os aluguéis com paginação e filtros.
     *
     * @param Request $request Requisição HTTP com parâmetros de busca
     * @return View Lista de aluguéis
     */
    public function index(Request $request): View
    {
        $rentals = $this->rentalService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
        );

        return view('admin.alugueis.index', compact('rentals'));
    }

    /**
     * Exibe os detalhes de um aluguel específico.
     *
     * @param Rental $aluguel Aluguel a ser exibido
     * @return View Detalhes do aluguel
     */
    public function show(Rental $aluguel): View
    {
        $aluguel->load(['user', 'book.author', 'book.category', 'fine']);

        return view('admin.alugueis.show', compact('aluguel'));
    }

    /**
     * Armazena um novo aluguel no sistema.
     *
     * @param StoreRentalRequest $request Dados validados do aluguel
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function store(StoreRentalRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Converter taxa_atraso se vier formatada (máscara de moeda)
        $taxaAtraso = 0.0;
        if (isset($validated['taxa_atraso']) && $validated['taxa_atraso'] !== null && $validated['taxa_atraso'] !== '') {
            $taxaAtraso = is_numeric($validated['taxa_atraso'])
                ? (float) $validated['taxa_atraso']
                : (float) str_replace(['R$', '.', ','], ['', '', '.'], $validated['taxa_atraso']);
        }

        $dto = new RentalDTO(
            usuarioId: (int) $validated['usuario_id'],
            livroId: (int) $validated['livro_id'],
            alugadoEm: Carbon::parse($validated['alugado_em']),
            dataDevolucao: Carbon::parse($validated['data_devolucao']),
            devolvidoEm: isset($validated['devolvido_em']) ? Carbon::parse($validated['devolvido_em']) : null,
            taxaAtraso: $taxaAtraso,
            status: RentalStatus::from($validated['status']),
        );

        $this->createRentalAction->execute($dto);

        return redirect()->route('admin.alugueis.index')
            ->with('success', 'Aluguel criado com sucesso!')
        ;
    }

    /**
     * Atualiza os dados de um aluguel existente.
     *
     * @param UpdateRentalRequest $request Dados validados do aluguel
     * @param Rental $aluguel Aluguel a ser atualizado
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function update(UpdateRentalRequest $request, Rental $aluguel): RedirectResponse
    {
        $validated = $request->validated();

        // Converter taxa_atraso se vier formatada (máscara de moeda)
        $taxaAtraso = 0.0;
        if (isset($validated['taxa_atraso']) && $validated['taxa_atraso'] !== null && $validated['taxa_atraso'] !== '') {
            $taxaAtraso = is_numeric($validated['taxa_atraso'])
                ? (float) $validated['taxa_atraso']
                : (float) str_replace(['R$', '.', ','], ['', '', '.'], $validated['taxa_atraso']);
        }

        $dto = new RentalDTO(
            usuarioId: (int) $validated['usuario_id'],
            livroId: (int) $validated['livro_id'],
            alugadoEm: Carbon::parse($validated['alugado_em']),
            dataDevolucao: Carbon::parse($validated['data_devolucao']),
            devolvidoEm: isset($validated['devolvido_em']) ? Carbon::parse($validated['devolvido_em']) : null,
            taxaAtraso: $taxaAtraso,
            status: RentalStatus::from($validated['status']),
        );

        $this->updateRentalAction->execute($aluguel, $dto);

        return redirect()->route('admin.alugueis.index')
            ->with('success', 'Aluguel atualizado com sucesso!')
        ;
    }
}
