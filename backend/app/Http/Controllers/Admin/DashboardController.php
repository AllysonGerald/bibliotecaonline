<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Rental;
use App\Models\Reservation;
use App\Models\User;
use App\Services\BookService;
use App\Services\ContactService;
use App\Services\RentalService;
use App\Services\ReservationService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controller responsável pelo dashboard administrativo.
 */
class DashboardController extends Controller
{
    public function __construct(
        private readonly BookService $bookService,
        private readonly UserService $userService,
        private readonly RentalService $rentalService,
        private readonly ReservationService $reservationService,
        private readonly ContactService $contactService,
    ) {
    }

    /**
     * Exibe o dashboard administrativo com estatísticas e atividades recentes.
     *
     * @return View Dashboard administrativo
     */
    public function index(): View
    {
        $user = Auth::user();
        $totalBooks = $this->bookService->getTotalCount();
        $totalUsers = $this->userService->getTotalCount();
        $totalRentals = $this->rentalService->getActiveCount();
        $totalReservations = $this->reservationService->getPendingOrConfirmedCount();
        $totalUnreadContacts = $this->contactService->getUnreadCount();

        $featuredBooks = $this->bookService->getMostRentedBooks(6);

        $activities = collect();

        // Aluguéis (criação e atualização)
        $rentals = Rental::with(['user', 'book'])->latest('updated_at')->take(10)->get();
        foreach ($rentals as $rental) {
            $isNew = $rental->created_at->equalTo($rental->updated_at);
            $activities->push([
                'type' => 'aluguel',
                'action' => $isNew ? 'criado' : 'atualizado',
                'title' => $rental->book->titulo ?? 'Livro removido',
                'user' => $rental->user->name ?? 'Usuário removido',
                'date' => $rental->updated_at,
                'route' => route('admin.alugueis.show', $rental),
                'icon' => 'book',
                'color' => '#8b5cf6',
            ]);
        }

        // Reservas (criação e atualização)
        $reservations = Reservation::with(['user', 'book'])->latest('updated_at')->take(10)->get();
        foreach ($reservations as $reservation) {
            $isNew = $reservation->created_at->equalTo($reservation->updated_at);
            $activities->push([
                'type' => 'reserva',
                'action' => $isNew ? 'criada' : 'atualizada',
                'title' => $reservation->book->titulo ?? 'Livro removido',
                'user' => $reservation->user->name ?? 'Usuário removido',
                'date' => $reservation->updated_at,
                'route' => route('admin.reservas.show', $reservation),
                'icon' => 'clock',
                'color' => '#ec4899',
            ]);
        }

        // Livros (criação e atualização)
        $books = Book::with(['author', 'category'])->latest('updated_at')->take(10)->get();
        foreach ($books as $book) {
            $isNew = $book->created_at->equalTo($book->updated_at);
            $activities->push([
                'type' => 'livro',
                'action' => $isNew ? 'criado' : 'atualizado',
                'title' => $book->titulo,
                'user' => 'Sistema',
                'date' => $book->updated_at,
                'route' => route('admin.livros.show', $book),
                'icon' => 'book-open',
                'color' => '#f97316',
            ]);
        }

        // Usuários (criação e atualização)
        $users = User::latest('updated_at')->take(10)->get();
        foreach ($users as $userItem) {
            $isNew = $userItem->created_at->equalTo($userItem->updated_at);
            $activities->push([
                'type' => 'usuario',
                'action' => $isNew ? 'criado' : 'atualizado',
                'title' => $userItem->name,
                'user' => 'Sistema',
                'date' => $userItem->updated_at,
                'route' => route('admin.usuarios.show', $userItem),
                'icon' => 'user',
                'color' => '#0ea5e9',
            ]);
        }

        // Autores (criação e atualização)
        $authors = Author::latest('updated_at')->take(10)->get();
        foreach ($authors as $author) {
            $isNew = $author->created_at->equalTo($author->updated_at);
            $activities->push([
                'type' => 'autor',
                'action' => $isNew ? 'criado' : 'atualizado',
                'title' => $author->nome,
                'user' => 'Sistema',
                'date' => $author->updated_at,
                'route' => route('admin.autores.show', $author),
                'icon' => 'pen-tool',
                'color' => '#10b981',
            ]);
        }

        // Categorias (criação e atualização)
        $categories = Category::latest('updated_at')->take(10)->get();
        foreach ($categories as $category) {
            $isNew = $category->created_at->equalTo($category->updated_at);
            $activities->push([
                'type' => 'categoria',
                'action' => $isNew ? 'criada' : 'atualizada',
                'title' => $category->nome,
                'user' => 'Sistema',
                'date' => $category->updated_at,
                'route' => route('admin.categorias.show', $category),
                'icon' => 'tag',
                'color' => '#8b5cf6',
            ]);
        }

        // Mensagens de Contato (criação)
        $contacts = Contact::latest('created_at')->take(10)->get();
        foreach ($contacts as $contact) {
            $activities->push([
                'type' => 'mensagem',
                'action' => 'enviada',
                'title' => $contact->assunto,
                'user' => $contact->nome,
                'date' => $contact->created_at,
                'route' => route('admin.contatos.show', $contact),
                'icon' => 'mail',
                'color' => '#10b981',
            ]);
        }

        $recentActivities = $activities->sortByDesc('date')->take(5)->values();

        return view('admin.dashboard', compact(
            'user',
            'totalBooks',
            'totalUsers',
            'totalRentals',
            'totalReservations',
            'totalUnreadContacts',
            'featuredBooks',
            'recentActivities',
        ));
    }
}
