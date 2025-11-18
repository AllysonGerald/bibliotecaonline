<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\BookStatus;
use App\Enums\RentalStatus;
use App\Models\Book;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRentalStoreTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanRentAvailableBook(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'status' => BookStatus::DISPONIVEL,
            'quantidade' => 5,
        ]);

        $response = $this->actingAs($user)->post(route('alugueis.store', $book));

        $response->assertRedirect(route('meus-alugueis'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('alugueis', [
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => RentalStatus::ATIVO->value,
        ]);
        $book->refresh();
        $this->assertEquals(BookStatus::ALUGADO, $book->status);
    }

    public function testUserCannotRentUnavailableBook(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'status' => BookStatus::ALUGADO,
        ]);

        $response = $this->actingAs($user)->post(route('alugueis.store', $book));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Este livro não está disponível para aluguel.');
        $this->assertDatabaseMissing('alugueis', [
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
        ]);
    }

    public function testUserCannotRentSameBookTwice(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create([
            'status' => BookStatus::DISPONIVEL,
            'quantidade' => 5,
        ]);

        Rental::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'status' => RentalStatus::ATIVO,
        ]);

        $response = $this->actingAs($user)->post(route('alugueis.store', $book));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Você já possui um aluguel ativo deste livro.');
        $this->assertDatabaseCount('alugueis', 1);
    }

    public function testGuestCannotRentBook(): void
    {
        $book = Book::factory()->create([
            'status' => BookStatus::DISPONIVEL,
        ]);

        $response = $this->post(route('alugueis.store', $book));

        $response->assertRedirect(route('login'));
    }
}
