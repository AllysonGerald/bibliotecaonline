<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Contacts\CreateContactAction;
use App\DTOs\ContactDTO;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(
        private readonly CreateContactAction $createContactAction,
    ) {
    }

    public function show(): View
    {
        return view('contato');
    }

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
