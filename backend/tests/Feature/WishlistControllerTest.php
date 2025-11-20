<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanAccessWishlistPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Wishlist::factory()->create(['usuario_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('lista-desejos'));

        $response->assertStatus(200);
        $response->assertSee('Lista de Desejos');
    }

    public function testGuestCannotAccessWishlistPage(): void
    {
        $response = $this->get(route('lista-desejos'));

        $response->assertRedirect(route('login'));
    }

    public function testUserCanAddBookToWishlist(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('lista-desejos.store', $book));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Livro adicionado à lista de desejos com sucesso!');
        $this->assertDatabaseHas('lista_desejos', [
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
        ]);
    }

    public function testUserCannotAddSameBookTwiceToWishlist(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();
        Wishlist::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
        ]);

        $response = $this->actingAs($user)->post(route('lista-desejos.store', $book));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Este livro já está na sua lista de desejos.');
        $this->assertDatabaseCount('lista_desejos', 1);
    }

    public function testUserCannotRemoveOtherUserWishlistItem(): void
    {
        /** @var User $user1 */
        $user1 = User::factory()->create();
        /** @var User $user2 */
        $user2 = User::factory()->create();
        $book = Book::factory()->create();
        $wishlist = Wishlist::factory()->create([
            'usuario_id' => $user2->id,
            'livro_id' => $book->id,
        ]);

        $response = $this->actingAs($user1)->delete(route('lista-desejos.destroy', $wishlist));

        $response->assertStatus(403);
        $this->assertDatabaseHas('lista_desejos', [
            'id' => $wishlist->id,
        ]);
    }

    public function testUserCanRemoveBookFromWishlist(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $wishlist = Wishlist::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
        ]);

        $response = $this->actingAs($user)->delete(route('lista-desejos.destroy', $wishlist));

        $response->assertRedirect(route('lista-desejos'));
        $response->assertSessionHas('success', 'Livro removido da lista de desejos com sucesso!');
        $this->assertDatabaseMissing('lista_desejos', [
            'id' => $wishlist->id,
        ]);
    }

    public function testUserCanSeeOnlyTheirOwnWishlistItems(): void
    {
        /** @var User $user1 */
        $user1 = User::factory()->create();
        /** @var User $user2 */
        $user2 = User::factory()->create();
        $book1 = Book::factory()->create();
        $book2 = Book::factory()->create();

        $wishlist1 = Wishlist::factory()->create([
            'usuario_id' => $user1->id,
            'livro_id' => $book1->id,
        ]);
        $wishlist2 = Wishlist::factory()->create([
            'usuario_id' => $user2->id,
            'livro_id' => $book2->id,
        ]);

        $response = $this->actingAs($user1)->get(route('lista-desejos'));

        $response->assertStatus(200);
        $response->assertSee($wishlist1->book->titulo);
        $response->assertDontSee($wishlist2->book->titulo);
    }

    public function testWishlistPageDisplaysBookInformation(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $wishlist = Wishlist::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
        ]);

        $response = $this->actingAs($user)->get(route('lista-desejos'));

        $response->assertStatus(200);
        $response->assertSee($wishlist->book->titulo);
        $response->assertSee($wishlist->book->author->nome);
        $response->assertSee($wishlist->book->category->nome);
    }

    public function testWishlistPageShowsEmptyStateWhenNoItems(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('lista-desejos'));

        $response->assertStatus(200);
        $response->assertSee('Sua lista de desejos está vazia');
    }
}
