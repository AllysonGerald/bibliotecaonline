<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanAccessBooksIndexPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Book::factory()->count(3)->create();

        $response = $this->actingAs($user)->get(route('livros.index'));

        $response->assertStatus(200);
        $response->assertSee('Catálogo de Livros');
    }

    public function testGuestCannotAccessBooksIndexPage(): void
    {
        $response = $this->get(route('livros.index'));

        $response->assertRedirect(route('login'));
    }

    public function testAuthenticatedUserCanViewBookDetails(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->get(route('livros.show', $book));

        $response->assertStatus(200);
        $response->assertSee($book->titulo);
        $response->assertSee($book->author->nome);
    }

    public function testGuestCannotViewBookDetails(): void
    {
        $book = Book::factory()->create();

        $response = $this->get(route('livros.show', $book));

        $response->assertRedirect(route('login'));
    }

    public function testBooksIndexPageShowsSearchResults(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Book::factory()->create(['titulo' => 'Livro de Teste']);
        Book::factory()->create(['titulo' => 'Outro Livro']);

        $response = $this->actingAs($user)->get(route('livros.index', ['search' => 'Teste']));

        $response->assertStatus(200);
        $response->assertSee('Livro de Teste');
    }

    public function testBooksIndexPageFiltersByCategory(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $category = \App\Models\Category::factory()->create();
        Book::factory()->create(['categoria_id' => $category->id]);
        Book::factory()->create();

        $response = $this->actingAs($user)->get(route('livros.index', ['categoria_id' => $category->id]));

        $response->assertStatus(200);
    }

    public function testBooksIndexPageFiltersByAuthor(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $author = \App\Models\Author::factory()->create();
        Book::factory()->create(['autor_id' => $author->id]);
        Book::factory()->create();

        $response = $this->actingAs($user)->get(route('livros.index', ['autor_id' => $author->id]));

        $response->assertStatus(200);
    }

    public function testBookShowPageDisplaysCorrectInformation(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->get(route('livros.show', $book));

        $response->assertStatus(200);
        $response->assertSee($book->titulo);
        $response->assertSee($book->author->nome);
        $response->assertSee($book->category->nome);
        if ($book->descricao) {
            $response->assertSee($book->descricao);
        }
    }
}

