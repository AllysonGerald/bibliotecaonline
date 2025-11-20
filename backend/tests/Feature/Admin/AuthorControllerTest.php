<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
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

    public function testAdminCanAccessAuthorsIndexPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.autores.index'));

        $response->assertStatus(200);
        $response->assertSee('Gerenciar Autores');
    }

    public function testAdminCanAccessCreateAuthorPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.autores.create'));

        $response->assertStatus(200);
        $response->assertSee('Novo Autor');
    }

    public function testAdminCanAccessEditAuthorPage(): void
    {
        $author = Author::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.autores.edit', $author));

        $response->assertStatus(200);
        $response->assertSee('Editar Autor');
    }

    public function testAdminCanAccessShowAuthorPage(): void
    {
        $author = Author::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.autores.show', $author));

        $response->assertStatus(200);
        $response->assertSee($author->nome);
    }

    public function testAdminCanCreateAuthor(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.autores.store'), [
            'nome' => 'Autor de Teste',
            'biografia' => 'Biografia do autor de teste',
            'data_nascimento' => '1980-01-01',
        ]);

        $response->assertRedirect(route('admin.autores.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('autores', [
            'nome' => 'Autor de Teste',
        ]);
    }

    public function testAdminCanCreateAuthorViaAjax(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders([
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ])
            ->post(route('admin.autores.store'), [
                'nome' => 'Autor AJAX',
                'biografia' => 'Biografia do autor via AJAX',
            ])
        ;

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Autor criado com sucesso!',
        ]);
        $response->assertJsonStructure([
            'success',
            'message',
            'author' => [
                'id',
                'nome',
            ],
        ]);

        $this->assertDatabaseHas('autores', [
            'nome' => 'Autor AJAX',
        ]);
    }

    public function testAdminCanDeleteAuthor(): void
    {
        $author = Author::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.autores.destroy', $author));

        $response->assertRedirect(route('admin.autores.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('autores', [
            'id' => $author->id,
        ]);
    }

    public function testAdminCannotCreateAuthorViaAjaxWithInvalidData(): void
    {
        $response = $this->actingAs($this->admin)
            ->withHeaders([
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ])
            ->post(route('admin.autores.store'), [
                'nome' => '',
            ])
        ;

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nome']);
    }

    public function testAdminCannotCreateAuthorWithInvalidData(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.autores.store'), [
            'nome' => '',
        ]);

        $response->assertSessionHasErrors(['nome']);
    }

    public function testAdminCannotUpdateAuthorWithInvalidData(): void
    {
        $author = Author::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.autores.update', $author), [
            'nome' => '',
        ]);

        $response->assertSessionHasErrors(['nome']);
    }

    public function testAdminCanUpdateAuthor(): void
    {
        $author = Author::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.autores.update', $author), [
            'nome' => 'Autor Atualizado',
            'biografia' => 'Nova biografia',
            'data_nascimento' => '1985-05-15',
        ]);

        $response->assertRedirect(route('admin.autores.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('autores', [
            'id' => $author->id,
            'nome' => 'Autor Atualizado',
        ]);
    }

    public function testAuthorIndexPageShowsSearchResults(): void
    {
        Author::factory()->create(['nome' => 'Autor Teste']);
        Author::factory()->create(['nome' => 'Outro Autor']);

        $response = $this->actingAs($this->admin)->get(route('admin.autores.index', ['search' => 'Teste']));

        $response->assertStatus(200);
        $response->assertSee('Autor Teste');
        $response->assertDontSee('Outro Autor');
    }

    public function testGuestCannotAccessAuthorsIndexPage(): void
    {
        $response = $this->get(route('admin.autores.index'));

        $response->assertRedirect(route('login'));
    }

    public function testGuestCannotCreateAuthorViaAjax(): void
    {
        $response = $this->withHeaders([
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
        ])->post(route('admin.autores.store'), [
            'nome' => 'Autor Não Autenticado',
        ]);

        $response->assertStatus(401);
    }

    public function testRegularUserCannotAccessAuthorsIndexPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.autores.index'));

        $response->assertStatus(403);
    }

    public function testRegularUserCannotCreateAuthorViaAjax(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withHeaders([
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ])
            ->post(route('admin.autores.store'), [
                'nome' => 'Autor Não Autorizado',
            ])
        ;

        $response->assertStatus(403);
    }
}
