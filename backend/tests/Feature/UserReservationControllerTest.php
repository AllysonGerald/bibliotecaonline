<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\ReservationStatus;
use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanAccessReservationsPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Reservation::factory()->create(['usuario_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('minhas-reservas'));

        $response->assertStatus(200);
        $response->assertSee('Minhas Reservas');
    }

    public function testGuestCannotAccessReservationsPage(): void
    {
        $response = $this->get(route('minhas-reservas'));

        $response->assertRedirect(route('login'));
    }

    public function testReservationsPageDisplaysReservationInformation(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $reservation = Reservation::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => ReservationStatus::PENDENTE,
        ]);

        $response = $this->actingAs($user)->get(route('minhas-reservas'));

        $response->assertStatus(200);
        $response->assertSee($reservation->book->titulo);
        $response->assertSee($reservation->book->author->nome);
        $response->assertSee($reservation->reservado_em->format('d/m/Y'));
        $response->assertSee($reservation->expira_em->format('d/m/Y'));
    }

    public function testReservationsPageShowsCancelledReservations(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        Reservation::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => ReservationStatus::CANCELADA,
        ]);

        $response = $this->actingAs($user)->get(route('minhas-reservas', ['status' => 'cancelada']));

        $response->assertStatus(200);
    }

    public function testReservationsPageShowsConfirmedReservations(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        Reservation::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => ReservationStatus::CONFIRMADA,
        ]);

        $response = $this->actingAs($user)->get(route('minhas-reservas', ['status' => 'confirmada']));

        $response->assertStatus(200);
    }

    public function testReservationsPageShowsEmptyStateWhenNoReservations(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('minhas-reservas'));

        $response->assertStatus(200);
        $response->assertSee('Nenhuma reserva encontrada');
    }

    public function testReservationsPageShowsExpiredReservations(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        Reservation::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => ReservationStatus::PENDENTE,
            'expira_em' => now()->subDays(5),
        ]);

        $response = $this->actingAs($user)->get(route('minhas-reservas'));

        $response->assertStatus(200);
    }

    public function testReservationsPageShowsPendingReservations(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        Reservation::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => ReservationStatus::PENDENTE,
        ]);

        $response = $this->actingAs($user)->get(route('minhas-reservas', ['status' => 'pendente']));

        $response->assertStatus(200);
    }

    public function testUserCanSeeOnlyTheirOwnReservations(): void
    {
        /** @var User $user1 */
        $user1 = User::factory()->create();
        /** @var User $user2 */
        $user2 = User::factory()->create();

        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();

        $reservation1 = Reservation::factory()->create([
            'usuario_id' => $user1->id,
            'livro_id' => $book1->id,
        ]);
        $reservation2 = Reservation::factory()->create([
            'usuario_id' => $user2->id,
            'livro_id' => $book2->id,
        ]);

        $response = $this->actingAs($user1)->get(route('minhas-reservas'));

        $response->assertStatus(200);
        $response->assertSee($reservation1->book->titulo);
        $response->assertDontSee($reservation2->book->titulo);
    }
}
