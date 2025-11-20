<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\RentalStatus;
use App\Models\Book;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalControllerTest extends TestCase
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

    public function testAdminCanAccessCreateRentalPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.alugueis.create'));

        $response->assertStatus(200);
        $response->assertSee('Novo Aluguel');
    }

    public function testAdminCanAccessEditRentalPage(): void
    {
        $rental = Rental::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.alugueis.edit', $rental));

        $response->assertStatus(200);
        $response->assertSee('Editar Aluguel');
    }

    public function testAdminCanAccessRentalsIndexPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.alugueis.index'));

        $response->assertStatus(200);
        $response->assertSee('Gerenciar Aluguéis');
    }

    public function testAdminCanAccessShowRentalPage(): void
    {
        $rental = Rental::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.alugueis.show', $rental));

        $response->assertStatus(200);
        $response->assertSee('Detalhes do Aluguel');
    }

    public function testAdminCanCreateRental(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->post(route('admin.alugueis.store'), [
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'alugado_em' => now()->format('Y-m-d\TH:i'),
            'data_devolucao' => now()->addDays(7)->format('Y-m-d\TH:i'),
            'status' => RentalStatus::ATIVO->value,
        ]);

        $response->assertRedirect(route('admin.alugueis.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('alugueis', [
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => RentalStatus::ATIVO->value,
        ]);
    }

    public function testAdminCanDeleteRental(): void
    {
        $rental = Rental::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.alugueis.destroy', $rental));

        $response->assertRedirect(route('admin.alugueis.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('alugueis', [
            'id' => $rental->id,
        ]);
    }

    public function testAdminCannotCreateRentalWithInvalidData(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.alugueis.store'), []);

        $response->assertSessionHasErrors(['usuario_id', 'livro_id', 'alugado_em', 'data_devolucao', 'status']);
    }

    public function testAdminCannotUpdateRentalWithInvalidData(): void
    {
        $rental = Rental::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.alugueis.update', $rental), []);

        $response->assertSessionHasErrors(['usuario_id', 'livro_id', 'alugado_em', 'data_devolucao', 'status']);
    }

    public function testAdminCanUpdateRental(): void
    {
        $rental = Rental::factory()->create();
        /** @var User $newUser */
        $newUser = User::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.alugueis.update', $rental), [
            'usuario_id' => $newUser->id,
            'livro_id' => $rental->livro_id,
            'alugado_em' => $rental->alugado_em->format('Y-m-d\TH:i'),
            'data_devolucao' => $rental->data_devolucao->format('Y-m-d\TH:i'),
            'status' => RentalStatus::DEVOLVIDO->value,
        ]);

        $response->assertRedirect(route('admin.alugueis.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('alugueis', [
            'id' => $rental->id,
            'usuario_id' => $newUser->id,
            'status' => RentalStatus::DEVOLVIDO->value,
        ]);
    }

    public function testGuestCannotAccessRentalsIndexPage(): void
    {
        $response = $this->get(route('admin.alugueis.index'));

        $response->assertRedirect(route('login'));
    }

    public function testRegularUserCannotAccessRentalsIndexPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.alugueis.index'));

        $response->assertStatus(403);
    }

    public function testRentalIndexPageShowsSearchResults(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['name' => 'Usuário Teste']);
        Rental::factory()->create(['usuario_id' => $user->id]);
        Rental::factory()->create(['usuario_id' => User::factory()->create(['name' => 'Outro Usuário'])->id]);

        $response = $this->actingAs($this->admin)->get(route('admin.alugueis.index', ['search' => 'Teste']));

        $response->assertStatus(200);
        $response->assertSee('Usuário Teste');
    }
}
