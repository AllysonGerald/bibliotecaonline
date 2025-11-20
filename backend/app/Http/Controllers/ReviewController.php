<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function destroy(Review $review): RedirectResponse
    {
        $user = auth()->user();

        // Verificar se a avaliação pertence ao usuário
        if ($review->usuario_id !== $user->id) {
            abort(403, 'Você não tem permissão para excluir esta avaliação.');
        }

        $review->delete();

        return redirect()->back()
            ->with('success', 'Avaliação removida com sucesso!')
        ;
    }

    public function store(StoreReviewRequest $request, Book $livro): RedirectResponse
    {
        $user = auth()->user();

        // Verificar se o usuário já avaliou este livro
        $existingReview = Review::where('usuario_id', $user->id)
            ->where('livro_id', $livro->id)
            ->first()
        ;

        if ($existingReview) {
            return redirect()->back()
                ->with('error', 'Você já avaliou este livro. Você pode editar sua avaliação existente.')
            ;
        }

        Review::create([
            'usuario_id' => $user->id,
            'livro_id' => $livro->id,
            'nota' => $request->nota,
            'comentario' => $request->comentario,
        ]);

        return redirect()->back()
            ->with('success', 'Avaliação enviada com sucesso!')
        ;
    }

    public function update(UpdateReviewRequest $request, Review $review): RedirectResponse
    {
        $user = auth()->user();

        // Verificar se a avaliação pertence ao usuário
        if ($review->usuario_id !== $user->id) {
            abort(403, 'Você não tem permissão para editar esta avaliação.');
        }

        // Garantir que string vazia seja convertida para null
        $comentario = $request->filled('comentario') && trim($request->comentario) !== ''
            ? trim($request->comentario)
            : null;

        $review->update([
            'nota' => (int) $request->nota,
            'comentario' => $comentario,
        ]);

        return redirect()->back()
            ->with('success', 'Avaliação atualizada com sucesso!')
        ;
    }
}
