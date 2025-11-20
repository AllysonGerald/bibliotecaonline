<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCannotAccessRegisterPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('register'));

        $response->assertRedirect(route('home'));
    }

    public function testRegisterPageCanBeRendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertSee('Criar Conta');
        $response->assertSee('Nome Completo');
        $response->assertSee('E-mail');
    }

    public function testRegisterRequiresEmail(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function testRegisterRequiresName(): void
    {
        $response = $this->post(route('register'), [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function testRegisterRequiresPassword(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function testRegisterRequiresPasswordConfirmation(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function testRegisterRequiresUniqueEmail(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function testRegisterRequiresValidEmailFormat(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function testUserCanRegisterWithoutTelephone(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Maria Santos',
            'email' => 'maria@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $user = User::where('email', 'maria@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNull($user->telefone);
    }

    public function testUserCanRegisterWithValidData(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'telefone' => '(11) 98765-4321',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $user = User::where('email', 'joao@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('João Silva', $user->name);
        $this->assertEquals(UserRole::USUARIO, $user->papel);
        $this->assertTrue($user->ativo);
    }
}
