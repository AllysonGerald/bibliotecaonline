<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
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

    public function testAdminCanAccessCreateUserPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.usuarios.create'));

        $response->assertStatus(200);
        $response->assertSee('Novo Usuário');
    }

    public function testAdminCanAccessEditUserPage(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.usuarios.edit', $user));

        $response->assertStatus(200);
        $response->assertSee('Editar Usuário');
    }

    public function testAdminCanAccessShowUserPage(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('admin.usuarios.show', $user));

        $response->assertStatus(200);
        $response->assertSee('Detalhes do Usuário');
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    public function testAdminCanAccessUsersIndexPage(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.usuarios.index'));

        $response->assertStatus(200);
        $response->assertSee('Gerenciar Usuários');
    }

    public function testAdminCanCreateUser(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.usuarios.store'), [
            'name' => 'Novo Usuário',
            'email' => 'novo@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'papel' => UserRole::USUARIO->value,
            'ativo' => true,
        ]);

        $response->assertRedirect(route('admin.usuarios.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'email' => 'novo@example.com',
            'papel' => UserRole::USUARIO->value,
        ]);
    }

    public function testAdminCanDeleteUser(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.usuarios.destroy', $user));

        $response->assertRedirect(route('admin.usuarios.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function testAdminCannotCreateUserWithDuplicateEmail(): void
    {
        User::factory()->create(['email' => 'existente@example.com']);

        $response = $this->actingAs($this->admin)->post(route('admin.usuarios.store'), [
            'name' => 'Novo Usuário',
            'email' => 'existente@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'papel' => UserRole::USUARIO->value,
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function testAdminCannotCreateUserWithInvalidData(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.usuarios.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'papel']);
    }

    public function testAdminCannotUpdateUserWithInvalidData(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.usuarios.update', $user), []);

        $response->assertSessionHasErrors(['name', 'email', 'papel']);
    }

    public function testAdminCanUpdateUser(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.usuarios.update', $user), [
            'name' => 'Nome Atualizado',
            'email' => $user->email,
            'papel' => UserRole::ADMIN->value,
            'ativo' => false,
        ]);

        $response->assertRedirect(route('admin.usuarios.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nome Atualizado',
            'papel' => UserRole::ADMIN->value,
            'ativo' => false,
        ]);
    }

    public function testAdminCanUpdateUserPassword(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.usuarios.update', $user), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
            'papel' => $user->papel->value,
            'ativo' => $user->ativo,
        ]);

        $response->assertRedirect(route('admin.usuarios.index'));
        $response->assertSessionHas('success');
    }

    public function testGuestCannotAccessUsersIndexPage(): void
    {
        $response = $this->get(route('admin.usuarios.index'));

        $response->assertRedirect(route('login'));
    }

    public function testRegularUserCannotAccessUsersIndexPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.usuarios.index'));

        $response->assertStatus(403);
    }

    public function testUserIndexPageFiltersByRole(): void
    {
        User::factory()->create(['papel' => UserRole::ADMIN]);
        User::factory()->create(['papel' => UserRole::USUARIO]);

        $response = $this->actingAs($this->admin)->get(route('admin.usuarios.index', ['papel' => UserRole::ADMIN->value]));

        $response->assertStatus(200);
    }

    public function testUserIndexPageFiltersByStatus(): void
    {
        User::factory()->create(['ativo' => true]);
        User::factory()->create(['ativo' => false]);

        $response = $this->actingAs($this->admin)->get(route('admin.usuarios.index', ['ativo' => '1']));

        $response->assertStatus(200);
    }

    public function testUserIndexPageShowsSearchResults(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['name' => 'Usuário Teste']);
        User::factory()->create(['name' => 'Outro Usuário']);

        $response = $this->actingAs($this->admin)->get(route('admin.usuarios.index', ['search' => 'Teste']));

        $response->assertStatus(200);
        $response->assertSee('Usuário Teste');
    }
}
