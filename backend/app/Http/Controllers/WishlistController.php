<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function destroy(Wishlist $wishlist): RedirectResponse
    {
        $user = auth()->user();

        // Verificar se o item pertence ao usuário
        if ($wishlist->usuario_id !== $user->id) {
            abort(403, 'Você não tem permissão para remover este item.');
        }

        $wishlist->delete();

        return redirect()->route('lista-desejos')
            ->with('success', 'Livro removido da lista de desejos com sucesso!')
        ;
    }

    public function index(): View
    {
        $user = auth()->user();
        $wishlists = Wishlist::with(['book.author', 'book.category'])
            ->where('usuario_id', $user->id)
            ->latest()
            ->get()
        ;

        return view('user.wishlist', compact('wishlists'));
    }

    public function store(Book $livro): RedirectResponse
    {
        $user = auth()->user();

        // Verificar se já está na lista de desejos
        $exists = Wishlist::where('usuario_id', $user->id)
            ->where('livro_id', $livro->id)
            ->exists()
        ;

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Este livro já está na sua lista de desejos.')
            ;
        }

        Wishlist::create([
            'usuario_id' => $user->id,
            'livro_id' => $livro->id,
        ]);

        return redirect()->back()
            ->with('success', 'Livro adicionado à lista de desejos com sucesso!')
        ;
    }
}
