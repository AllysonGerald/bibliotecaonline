<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(
        private readonly ContactService $contactService,
    ) {
    }

    public function destroy(Contact $contato): RedirectResponse
    {
        $this->contactService->delete($contato);

        return redirect()->route('admin.contatos.index')
            ->with('success', 'Mensagem excluída com sucesso!')
        ;
    }

    public function index(Request $request): View
    {
        $contacts = $this->contactService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
        );

        $unreadCount = Contact::unread()->count();

        return view('admin.contatos.index', compact('contacts', 'unreadCount'));
    }

    public function markAsRead(Contact $contato): RedirectResponse
    {
        $this->contactService->markAsRead($contato);

        return redirect()->route('admin.contatos.show', $contato)
            ->with('success', 'Mensagem marcada como lida!')
        ;
    }

    public function show(Contact $contato): View
    {
        if (!$contato->lido) {
            $this->contactService->markAsRead($contato);
            $contato->refresh();
        }

        return view('admin.contatos.show', compact('contato'));
    }
}
