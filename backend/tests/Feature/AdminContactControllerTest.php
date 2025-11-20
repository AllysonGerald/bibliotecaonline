<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContactControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminCanAccessContactsIndexPage(): void
    {
        /** @var User $admin */
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.contatos.index'));

        $response->assertStatus(200);
        $response->assertSee('Mensagens de Contato');
    }

    public function testAdminCanDeleteContact(): void
    {
        /** @var User $admin */
        $admin = User::factory()->admin()->create();

        /** @var Contact $contact */
        $contact = Contact::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.contatos.destroy', $contact));

        $response->assertRedirect(route('admin.contatos.index'));
        $response->assertSessionHas('success', 'Mensagem excluída com sucesso!');

        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }

    public function testAdminCanMarkContactAsRead(): void
    {
        /** @var User $admin */
        $admin = User::factory()->admin()->create();

        /** @var Contact $contact */
        $contact = Contact::factory()->create([
            'lido' => false,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.contatos.mark-as-read', $contact));

        $response->assertRedirect(route('admin.contatos.show', $contact));
        $response->assertSessionHas('success', 'Mensagem marcada como lida!');

        $contact->refresh();
        $this->assertTrue($contact->lido);
        $this->assertNotNull($contact->lido_em);
    }

    public function testAdminCanViewContactDetails(): void
    {
        /** @var User $admin */
        $admin = User::factory()->admin()->create();

        /** @var Contact $contact */
        $contact = Contact::factory()->create([
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
            'assunto' => 'Dúvida sobre aluguel',
            'mensagem' => 'Mensagem de teste',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.contatos.show', $contact));

        $response->assertStatus(200);
        $response->assertSee('Detalhes da Mensagem');
        $response->assertSee('João Silva');
        $response->assertSee('joao@example.com');
        $response->assertSee('Dúvida sobre aluguel');
        $response->assertSee('Mensagem de teste');
    }

    public function testContactIsMarkedAsReadWhenViewed(): void
    {
        /** @var User $admin */
        $admin = User::factory()->admin()->create();

        /** @var Contact $contact */
        $contact = Contact::factory()->create([
            'lido' => false,
        ]);

        $this->assertFalse($contact->lido);

        $this->actingAs($admin)->get(route('admin.contatos.show', $contact));

        $contact->refresh();
        $this->assertTrue($contact->lido);
        $this->assertNotNull($contact->lido_em);
    }

    public function testContactsIndexShowsSearchResults(): void
    {
        /** @var User $admin */
        $admin = User::factory()->admin()->create();

        Contact::factory()->create([
            'nome' => 'João Silva',
            'email' => 'joao@example.com',
        ]);
        Contact::factory()->create([
            'nome' => 'Maria Santos',
            'email' => 'maria@example.com',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.contatos.index', ['search' => 'João']));

        $response->assertStatus(200);
        $response->assertSee('João Silva');
        $response->assertDontSee('Maria Santos');
    }

    public function testContactsIndexShowsUnreadCount(): void
    {
        /** @var User $admin */
        $admin = User::factory()->admin()->create();

        Contact::factory()->count(3)->create(['lido' => false]);
        Contact::factory()->count(2)->create(['lido' => true]);

        $response = $this->actingAs($admin)->get(route('admin.contatos.index'));

        $response->assertStatus(200);
        $response->assertSee('3 não lida(s)');
    }

    public function testGuestCannotAccessContactsIndexPage(): void
    {
        $response = $this->get(route('admin.contatos.index'));

        $response->assertRedirect(route('login'));
    }

    public function testRegularUserCannotAccessContactsIndexPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.contatos.index'));

        $response->assertForbidden();
    }

    public function testRegularUserCannotDeleteContact(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Contact $contact */
        $contact = Contact::factory()->create();

        $response = $this->actingAs($user)->delete(route('admin.contatos.destroy', $contact));

        $response->assertForbidden();
    }
}
