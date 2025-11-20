<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanAccessProfilePage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('perfil'));

        $response->assertStatus(200);
        $response->assertSee('Meu Perfil');
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    public function testGuestCannotAccessProfilePage(): void
    {
        $response = $this->get(route('perfil'));

        $response->assertRedirect(route('login'));
    }

    public function testProfilePageShowsUserStatistics(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('perfil'));

        $response->assertStatus(200);
        $response->assertSee('Estatísticas');
        $response->assertSee('Aluguéis');
        $response->assertSee('Reservas');
        $response->assertSee('Lista de Desejos');
        $response->assertSee('Avaliações');
    }

    public function testUserCannotUpdatePasswordWithoutConfirmation(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'newpassword123',
            // password_confirmation ausente
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function testUserCannotUpdatePasswordWithShortPassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function testUserCannotUpdateProfileWithInvalidEmail(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var User $otherUser */
        $otherUser = User::factory()->create(['email' => 'outro@example.com']);

        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'name' => $user->name,
            'email' => 'outro@example.com', // Email já em uso
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function testUserCanUpdatePassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('perfil'));
        $response->assertSessionHas('success', 'Perfil atualizado com sucesso!');

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function testUserCanUpdateProfile(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'Nome Antigo',
            'email' => 'antigo@example.com',
        ]);

        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'name' => 'Nome Novo',
            'email' => 'novo@example.com',
            'telefone' => '11999999999',
        ]);

        $response->assertRedirect(route('perfil'));
        $response->assertSessionHas('success', 'Perfil atualizado com sucesso!');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nome Novo',
            'email' => 'novo@example.com',
            'telefone' => '11999999999',
        ]);
    }

    public function testUserCanUpdateProfileWithoutChangingPassword(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $oldPassword = $user->password;

        $response = $this->actingAs($user)->put(route('perfil.update'), [
            'name' => 'Nome Atualizado',
            'email' => $user->email,
            // password não fornecido
        ]);

        $response->assertRedirect(route('perfil'));
        $response->assertSessionHas('success', 'Perfil atualizado com sucesso!');

        $user->refresh();
        $this->assertEquals('Nome Atualizado', $user->name);
        $this->assertEquals($oldPassword, $user->password); // Senha não mudou
    }
}
