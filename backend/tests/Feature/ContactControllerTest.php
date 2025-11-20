<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanAccessContactPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('contato'));

        $response->assertStatus(200);
        $response->assertSee('Entre em Contato');
    }

    public function testAuthenticatedUserCanSubmitContactForm(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('contato.store'), [
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'assunto' => 'Dúvida sobre aluguel',
            'mensagem' => 'Gostaria de saber mais informações sobre o processo de aluguel.',
        ]);

        $response->assertRedirect(route('contato'));
        $response->assertSessionHas('success', 'Sua mensagem foi enviada com sucesso! Entraremos em contato em breve.');
    }

    public function testContactFormValidatesEmailFormat(): void
    {
        $response = $this->post(route('contato.store'), [
            'nome' => 'João Silva',
            'email' => 'email-invalido',
            'assunto' => 'Teste',
            'mensagem' => 'Mensagem de teste',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function testContactFormValidatesMaxLength(): void
    {
        $response = $this->post(route('contato.store'), [
            'nome' => str_repeat('a', 256), // Excede 255 caracteres
            'email' => str_repeat('a', 250).'@example.com', // Excede 255 caracteres
            'assunto' => str_repeat('a', 256), // Excede 255 caracteres
            'mensagem' => str_repeat('a', 5001), // Excede 5000 caracteres
        ]);

        $response->assertSessionHasErrors(['nome', 'email', 'assunto', 'mensagem']);
    }

    public function testContactFormValidatesRequiredFields(): void
    {
        $response = $this->post(route('contato.store'), []);

        $response->assertSessionHasErrors(['nome', 'email', 'assunto', 'mensagem']);
    }

    public function testContactPagePreFillsUserDataWhenAuthenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->create([
            'name' => 'João Silva',
            'email' => 'joao@example.com',
        ]);

        $response = $this->actingAs($user)->get(route('contato'));

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    public function testContactPageShowsContactInformation(): void
    {
        $response = $this->get(route('contato'));

        $response->assertStatus(200);
        $response->assertSee('Informações de Contato');
        $response->assertSee('contato@biblioteca.com');
        $response->assertSee('(11) 1234-5678');
    }

    public function testGuestCanAccessContactPage(): void
    {
        $response = $this->get(route('contato'));

        $response->assertStatus(200);
        $response->assertSee('Entre em Contato');
    }

    public function testGuestCanSubmitContactForm(): void
    {
        $response = $this->post(route('contato.store'), [
            'nome' => 'Maria Santos',
            'email' => 'maria@example.com',
            'assunto' => 'Sugestão de livro',
            'mensagem' => 'Gostaria de sugerir a adição de novos livros ao acervo.',
        ]);

        $response->assertRedirect(route('contato'));
        $response->assertSessionHas('success', 'Sua mensagem foi enviada com sucesso! Entraremos em contato em breve.');
    }
}
