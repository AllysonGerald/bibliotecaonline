<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('contato');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        // Aqui você pode adicionar lógica para enviar email, salvar no banco, etc.
        // Por enquanto, apenas retornamos uma mensagem de sucesso

        return redirect()->route('contato')
            ->with('success', 'Sua mensagem foi enviada com sucesso! Entraremos em contato em breve.')
        ;
    }
}
