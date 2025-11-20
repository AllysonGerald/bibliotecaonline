<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Contacts\CreateContactAction;
use App\DTOs\ContactDTO;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controller responsável pelo formulário de contato público.
 */
class ContactController extends Controller
{
    public function __construct(
        private readonly CreateContactAction $createContactAction,
    ) {
    }

    /**
     * Exibe o formulário de contato.
     *
     * @return View Formulário de contato
     */
    public function show(): View
    {
        return view('contato');
    }

    /**
     * Processa e armazena uma nova mensagem de contato.
     *
     * @param ContactRequest $request Dados validados da mensagem
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        $dto = new ContactDTO(
            nome: $request->validated('nome'),
            email: $request->validated('email'),
            assunto: $request->validated('assunto'),
            mensagem: $request->validated('mensagem'),
        );

        $this->createContactAction->execute($dto);

        return redirect()->route('contato')
            ->with('success', 'Sua mensagem foi enviada com sucesso! Entraremos em contato em breve.')
        ;
    }
}
