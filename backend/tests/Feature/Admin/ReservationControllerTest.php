<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\ReservationStatus;
use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $admin */
        $admin = User::factory()->admin()->create();
        $this->admin = $admin;
    }

    public function testAdminCanAccessCreateReservationPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.reservas.create'));

        $response->assertStatus(200);
        $response->assertSee('Nova Reserva');
    }

    public function testAdminCanAccessEditReservationPage(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.reservas.edit', $reservation));

        $response->assertStatus(200);
        $response->assertSee('Editar Reserva');
    }

    public function testAdminCanAccessReservationsIndexPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.reservas.index'));

        $response->assertStatus(200);
        $response->assertSee('Gerenciar Reservas');
    }

    public function testAdminCanAccessShowReservationPage(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.reservas.show', $reservation));

        $response->assertStatus(200);
        $response->assertSee('Detalhes da Reserva');
    }

    public function testAdminCanCreateReservation(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->post(route('admin.reservas.store'), [
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'reservado_em' => now()->format('Y-m-d\TH:i'),
            'expira_em' => now()->addDays(7)->format('Y-m-d\TH:i'),
            'status' => ReservationStatus::PENDENTE->value,
        ]);

        $response->assertRedirect(route('admin.reservas.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservas', [
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => ReservationStatus::PENDENTE->value,
        ]);
    }

    public function testAdminCanDeleteReservation(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.reservas.destroy', $reservation));

        $response->assertRedirect(route('admin.reservas.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('reservas', [
            'id' => $reservation->id,
        ]);
    }

    public function testAdminCannotCreateReservationWithInvalidData(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.reservas.store'), []);

        $response->assertSessionHasErrors(['usuario_id', 'livro_id', 'reservado_em', 'expira_em', 'status']);
    }

    public function testAdminCannotUpdateReservationWithInvalidData(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.reservas.update', $reservation), []);

        $response->assertSessionHasErrors(['usuario_id', 'livro_id', 'reservado_em', 'expira_em', 'status']);
    }

    public function testAdminCanUpdateReservation(): void
    {
        $reservation = Reservation::factory()->create();
        /** @var User $newUser */
        $newUser = User::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.reservas.update', $reservation), [
            'usuario_id' => $newUser->id,
            'livro_id' => $reservation->livro_id,
            'reservado_em' => $reservation->reservado_em->format('Y-m-d\TH:i'),
            'expira_em' => $reservation->expira_em->format('Y-m-d\TH:i'),
            'status' => ReservationStatus::CONFIRMADA->value,
        ]);

        $response->assertRedirect(route('admin.reservas.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reservas', [
            'id' => $reservation->id,
            'usuario_id' => $newUser->id,
            'status' => ReservationStatus::CONFIRMADA->value,
        ]);
    }

    public function testGuestCannotAccessReservationsIndexPage(): void
    {
        $response = $this->get(route('admin.reservas.index'));

        $response->assertRedirect(route('login'));
    }

    public function testRegularUserCannotAccessReservationsIndexPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.reservas.index'));

        $response->assertStatus(403);
    }

    public function testReservationIndexPageShowsSearchResults(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['name' => 'Usuário Teste']);
        Reservation::factory()->create(['usuario_id' => $user->id]);
        Reservation::factory()->create(['usuario_id' => User::factory()->create(['name' => 'Outro Usuário'])->id]);

        $response = $this->actingAs($this->admin)->get(route('admin.reservas.index', ['search' => 'Teste']));

        $response->assertStatus(200);
        $response->assertSee('Usuário Teste');
    }
}
