<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\BookStatus;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
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

    public function testAdminCanAccessBooksIndexPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.livros.index'));

        $response->assertStatus(200);
        $response->assertSee('Gerenciar Livros');
    }

    public function testAdminCanAccessCreateBookPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.livros.create'));

        $response->assertStatus(200);
        $response->assertSee('Novo Livro');
    }

    public function testAdminCanAccessEditBookPage(): void
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.livros.edit', $book));

        $response->assertStatus(200);
        $response->assertSee('Editar Livro');
    }

    public function testAdminCanCreateBook(): void
    {
        $author = Author::factory()->create();
        $category = Category::factory()->create();
        $tag = Tag::factory()->create();

        $response = $this->actingAs($this->admin)->post(route('admin.livros.store'), [
            'titulo' => 'Livro de Teste',
            'descricao' => 'Descrição do livro de teste',
            'autor_id' => $author->id,
            'categoria_id' => $category->id,
            'isbn' => '9781234567890',
            'editora' => 'Editora Teste',
            'ano_publicacao' => 2024,
            'paginas' => 300,
            'preco' => 49.90,
            'status' => BookStatus::DISPONIVEL->value,
            'quantidade' => 10,
            'tags' => [$tag->id],
        ]);

        $response->assertRedirect(route('admin.livros.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('livros', [
            'titulo' => 'Livro de Teste',
            'isbn' => '9781234567890',
        ]);
    }

    public function testAdminCanDeleteBook(): void
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.livros.destroy', $book));

        $response->assertRedirect(route('admin.livros.index'));
        $response->assertSessionHas('success');

        $this->assertSoftDeleted('livros', [
            'id' => $book->id,
        ]);
    }

    public function testAdminCanFilterBooksByAuthor(): void
    {
        $author1 = Author::factory()->create();
        $author2 = Author::factory()->create();

        Book::factory()->create(['autor_id' => $author1->id]);
        Book::factory()->create(['autor_id' => $author2->id]);

        $response = $this->actingAs($this->admin)->get(route('admin.livros.index', [
            'autor_id' => $author1->id,
        ]));

        $response->assertStatus(200);
    }

    public function testAdminCanFilterBooksByCategory(): void
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();

        Book::factory()->create(['categoria_id' => $category1->id]);
        Book::factory()->create(['categoria_id' => $category2->id]);

        $response = $this->actingAs($this->admin)->get(route('admin.livros.index', [
            'categoria_id' => $category1->id,
        ]));

        $response->assertStatus(200);
        $response->assertSee($category1->nome);
    }

    public function testAdminCannotCreateBookWithInvalidData(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.livros.store'), [
            'titulo' => '',
        ]);

        $response->assertSessionHasErrors(['titulo', 'descricao', 'autor_id', 'categoria_id', 'isbn']);
    }

    public function testAdminCanSearchBooks(): void
    {
        Book::factory()->create(['titulo' => 'Livro de Busca']);
        Book::factory()->create(['titulo' => 'Outro Livro']);

        $response = $this->actingAs($this->admin)->get(route('admin.livros.index', [
            'search' => 'Busca',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Livro de Busca');
    }

    public function testAdminCanUpdateBook(): void
    {
        $author = Author::factory()->create();
        $category = Category::factory()->create();
        $book = Book::factory()->create([
            'autor_id' => $author->id,
            'categoria_id' => $category->id,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.livros.update', $book), [
            'titulo' => 'Livro Atualizado',
            'descricao' => 'Nova descrição',
            'autor_id' => $author->id,
            'categoria_id' => $category->id,
            'isbn' => $book->isbn,
            'editora' => 'Nova Editora',
            'ano_publicacao' => 2024,
            'paginas' => 400,
            'preco' => 59.90,
            'status' => BookStatus::RESERVADO->value,
            'quantidade' => 5,
        ]);

        $response->assertRedirect(route('admin.livros.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('livros', [
            'id' => $book->id,
            'titulo' => 'Livro Atualizado',
        ]);
    }

    public function testAdminCanViewBook(): void
    {
        $book = Book::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.livros.show', $book));

        $response->assertStatus(200);
        $response->assertSee($book->titulo);
    }

    public function testGuestCannotAccessBooksIndexPage(): void
    {
        $response = $this->get(route('admin.livros.index'));

        $response->assertRedirect(route('login'));
    }

    public function testRegularUserCannotAccessBooksIndexPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.livros.index'));

        $response->assertStatus(403);
    }
}
