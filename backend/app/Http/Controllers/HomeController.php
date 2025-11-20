<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\View\View;

/**
 * Controller responsável pela página inicial do usuário autenticado.
 */
class HomeController extends Controller
{
    public function __construct(
        private readonly BookService $bookService,
    ) {
    }

    /**
     * Exibe o dashboard do usuário com estatísticas e atividades recentes.
     *
     * @return View Dashboard do usuário
     */
    public function index(): View
    {
        $user = auth()->user();
        $activeRentals = $user->rentals()->where('status', \App\Enums\RentalStatus::ATIVO)->count();
        $pendingReservations = $user->reservations()->whereIn('status', [\App\Enums\ReservationStatus::PENDENTE, \App\Enums\ReservationStatus::CONFIRMADA])->count();
        $wishlistCount = $user->wishlists()->count();
        $reviewsCount = $user->reviews()->count();

        // Buscar livros aleatórios disponíveis (para área de usuário)
        $featuredBooks = $this->bookService->getRandomAvailableBooks(6);

        // Buscar últimas atividades do usuário
        $activities = collect();

        // Aluguéis do usuário (criação)
        $userRentals = $user->rentals()
            ->with('book')
            ->latest('created_at')
            ->take(10)
            ->get()
        ;
        foreach ($userRentals as $rental) {
            $activities->push([
                'type' => 'aluguel',
                'action' => 'criado',
                'title' => $rental->book->titulo ?? 'Livro removido',
                'date' => $rental->created_at,
                'route' => route('meus-alugueis'),
                'icon' => 'book',
                'color' => '#8b5cf6',
            ]);
        }

        // Reservas do usuário (criação, atualização, remoção)
        $userReservations = $user->reservations()
            ->with('book')
            ->latest('updated_at')
            ->take(10)
            ->get()
        ;
        foreach ($userReservations as $reservation) {
            $activities->push([
                'type' => 'reserva',
                'action' => 'criada',
                'title' => $reservation->book->titulo ?? 'Livro removido',
                'date' => $reservation->updated_at,
                'route' => route('minhas-reservas'),
                'icon' => 'clock',
                'color' => '#ec4899',
            ]);
        }

        // Wishlist do usuário (criação)
        $userWishlists = $user->wishlists()
            ->with('book')
            ->latest('created_at')
            ->take(10)
            ->get()
        ;
        foreach ($userWishlists as $wishlist) {
            $activities->push([
                'type' => 'wishlist',
                'action' => 'adicionado',
                'title' => $wishlist->book->titulo ?? 'Livro removido',
                'date' => $wishlist->created_at,
                'route' => route('wishlist'),
                'icon' => 'heart',
                'color' => '#f97316',
            ]);
        }

        // Ordenar por data (mais recente primeiro) e pegar os 5 mais recentes
        $recentActivities = $activities->sortByDesc('date')->take(5)->values();

        return view('home', compact(
            'user',
            'activeRentals',
            'pendingReservations',
            'wishlistCount',
            'reviewsCount',
            'featuredBooks',
            'recentActivities',
        ));
    }
}
