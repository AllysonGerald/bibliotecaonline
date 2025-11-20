<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
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

    public function testAdminCanAccessCategoriesIndexPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.categorias.index'));

        $response->assertStatus(200);
        $response->assertSee('Gerenciar Categorias');
    }

    public function testAdminCanAccessCreateCategoryPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.categorias.create'));

        $response->assertStatus(200);
        $response->assertSee('Nova Categoria');
    }

    public function testAdminCanAccessEditCategoryPage(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.categorias.edit', $category));

        $response->assertStatus(200);
        $response->assertSee('Editar Categoria');
    }

    public function testAdminCanAccessShowCategoryPage(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.categorias.show', $category));

        $response->assertStatus(200);
        $response->assertSee($category->nome);
    }

    public function testAdminCanCreateCategory(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.categorias.store'), [
            'nome' => 'Categoria de Teste',
            'descricao' => 'Descrição da categoria de teste',
            'icone' => '📚',
        ]);

        $response->assertRedirect(route('admin.categorias.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categorias', [
            'nome' => 'Categoria de Teste',
        ]);
    }

    public function testAdminCanDeleteCategory(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.categorias.destroy', $category));

        $response->assertRedirect(route('admin.categorias.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('categorias', [
            'id' => $category->id,
        ]);
    }

    public function testAdminCannotCreateCategoryWithInvalidData(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.categorias.store'), [
            'nome' => '',
        ]);

        $response->assertSessionHasErrors(['nome']);
    }

    public function testAdminCannotUpdateCategoryWithInvalidData(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.categorias.update', $category), [
            'nome' => '',
        ]);

        $response->assertSessionHasErrors(['nome']);
    }

    public function testAdminCanUpdateCategory(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.categorias.update', $category), [
            'nome' => 'Categoria Atualizada',
            'descricao' => 'Nova descrição',
            'icone' => '📖',
        ]);

        $response->assertRedirect(route('admin.categorias.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categorias', [
            'id' => $category->id,
            'nome' => 'Categoria Atualizada',
        ]);
    }

    public function testCategoryIndexPageShowsSearchResults(): void
    {
        Category::factory()->create(['nome' => 'Categoria Teste']);
        Category::factory()->create(['nome' => 'Outra Categoria']);

        $response = $this->actingAs($this->admin)->get(route('admin.categorias.index', ['search' => 'Teste']));

        $response->assertStatus(200);
        $response->assertSee('Categoria Teste');
        $response->assertDontSee('Outra Categoria');
    }

    public function testGuestCannotAccessCategoriesIndexPage(): void
    {
        $response = $this->get(route('admin.categorias.index'));

        $response->assertRedirect(route('login'));
    }

    public function testRegularUserCannotAccessCategoriesIndexPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.categorias.index'));

        $response->assertStatus(403);
    }
}
