<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\RentalStatus;
use App\Models\Book;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRentalControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanAccessRentalsPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Rental::factory()->create(['usuario_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('meus-alugueis'));

        $response->assertStatus(200);
        $response->assertSee('Meus Aluguéis');
    }

    public function testGuestCannotAccessRentalsPage(): void
    {
        $response = $this->get(route('meus-alugueis'));

        $response->assertRedirect(route('login'));
    }

    public function testRentalsPageDisplaysRentalInformation(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $rental = Rental::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => RentalStatus::ATIVO,
        ]);

        $response = $this->actingAs($user)->get(route('meus-alugueis'));

        $response->assertStatus(200);
        $response->assertSee($rental->book->titulo);
        $response->assertSee($rental->book->author->nome);
        $response->assertSee($rental->alugado_em->format('d/m/Y'));
        $response->assertSee($rental->data_devolucao->format('d/m/Y'));
    }

    public function testRentalsPageShowsActiveRentals(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        Rental::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => RentalStatus::ATIVO,
        ]);

        $response = $this->actingAs($user)->get(route('meus-alugueis', ['status' => 'ativo']));

        $response->assertStatus(200);
    }

    public function testRentalsPageShowsEmptyStateWhenNoRentals(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('meus-alugueis'));

        $response->assertStatus(200);
        $response->assertSee('Nenhum aluguel encontrado');
    }

    public function testRentalsPageShowsOverdueRentals(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        Rental::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => RentalStatus::ATRASADO,
            'data_devolucao' => now()->subDays(5),
        ]);

        $response = $this->actingAs($user)->get(route('meus-alugueis', ['status' => 'atrasado']));

        $response->assertStatus(200);
    }

    public function testRentalsPageShowsReturnedRentals(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        Rental::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => RentalStatus::DEVOLVIDO,
            'devolvido_em' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('meus-alugueis', ['status' => 'devolvido']));

        $response->assertStatus(200);
    }

    public function testUserCanSeeOnlyTheirOwnRentals(): void
    {
        /** @var User $user1 */
        $user1 = User::factory()->create();
        /** @var User $user2 */
        $user2 = User::factory()->create();

        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();

        $rental1 = Rental::factory()->create([
            'usuario_id' => $user1->id,
            'livro_id' => $book1->id,
        ]);
        $rental2 = Rental::factory()->create([
            'usuario_id' => $user2->id,
            'livro_id' => $book2->id,
        ]);

        $response = $this->actingAs($user1)->get(route('meus-alugueis'));

        $response->assertStatus(200);
        $response->assertSee($rental1->book->titulo);
        $response->assertDontSee($rental2->book->titulo);
    }
}
