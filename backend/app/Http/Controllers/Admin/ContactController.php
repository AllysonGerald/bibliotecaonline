<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsável pelo gerenciamento de mensagens de contato na área administrativa.
 */
class ContactController extends Controller
{
    public function __construct(
        private readonly ContactService $contactService,
    ) {
    }

    /**
     * Remove uma mensagem de contato do sistema.
     *
     * @param Contact $contato Mensagem a ser removida
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function destroy(Contact $contato): RedirectResponse
    {
        $this->contactService->delete($contato);

        return redirect()->route('admin.contatos.index')
            ->with('success', 'Mensagem excluída com sucesso!')
        ;
    }

    /**
     * Lista todas as mensagens de contato com paginação e filtros.
     *
     * @param Request $request Requisição HTTP com parâmetros de busca
     * @return View Lista de mensagens
     */
    public function index(Request $request): View
    {
        $contacts = $this->contactService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
        );

        $unreadCount = $this->contactService->getUnreadCount();

        return view('admin.contatos.index', compact('contacts', 'unreadCount'));
    }

    /**
     * Marca uma mensagem de contato como lida.
     *
     * @param Contact $contato Mensagem a ser marcada como lida
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function markAsRead(Contact $contato): RedirectResponse
    {
        $this->contactService->markAsRead($contato);

        return redirect()->route('admin.contatos.show', $contato)
            ->with('success', 'Mensagem marcada como lida!')
        ;
    }

    /**
     * Exibe os detalhes de uma mensagem de contato específica.
     * Marca automaticamente como lida ao visualizar.
     *
     * @param Contact $contato Mensagem a ser exibida
     * @return View Detalhes da mensagem
     */
    public function show(Contact $contato): View
    {
        if (!$contato->lido) {
            $this->contactService->markAsRead($contato);
            $contato->refresh();
        }

        return view('admin.contatos.show', compact('contato'));
    }
}
