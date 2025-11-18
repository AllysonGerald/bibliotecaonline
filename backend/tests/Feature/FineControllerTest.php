<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Fine;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FineControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanAccessFinesPage(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $rental = Rental::factory()->create(['usuario_id' => $user->id]);
        Fine::factory()->create([
            'usuario_id' => $user->id,
            'aluguel_id' => $rental->id,
        ]);

        $response = $this->actingAs($user)->get(route('minhas-multas'));

        $response->assertStatus(200);
        $response->assertSee('Minhas Multas');
    }

    public function testGuestCannotAccessFinesPage(): void
    {
        $response = $this->get(route('minhas-multas'));

        $response->assertRedirect(route('login'));
    }

    public function testUserCanSeeOnlyTheirOwnFines(): void
    {
        /** @var User $user1 */
        $user1 = User::factory()->create();
        /** @var User $user2 */
        $user2 = User::factory()->create();

        $rental1 = Rental::factory()->create(['usuario_id' => $user1->id]);
        $rental2 = Rental::factory()->create(['usuario_id' => $user2->id]);

        $fine1 = Fine::factory()->create([
            'usuario_id' => $user1->id,
            'aluguel_id' => $rental1->id,
            'valor' => 25.50,
        ]);
        $fine2 = Fine::factory()->create([
            'usuario_id' => $user2->id,
            'aluguel_id' => $rental2->id,
            'valor' => 30.00,
        ]);

        $response = $this->actingAs($user1)->get(route('minhas-multas'));

        $response->assertStatus(200);
        $response->assertSee('R$ 25,50');
        $response->assertDontSee('R$ 30,00');
    }

    public function testFinesPageShowsUnpaidFines(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $rental = Rental::factory()->create(['usuario_id' => $user->id]);

        Fine::factory()->create([
            'usuario_id' => $user->id,
            'aluguel_id' => $rental->id,
            'paga' => false,
        ]);

        $response = $this->actingAs($user)->get(route('minhas-multas', ['status' => 'pendente']));

        $response->assertStatus(200);
    }

    public function testFinesPageShowsPaidFines(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $rental = Rental::factory()->create(['usuario_id' => $user->id]);

        Fine::factory()->create([
            'usuario_id' => $user->id,
            'aluguel_id' => $rental->id,
            'paga' => true,
        ]);

        $response = $this->actingAs($user)->get(route('minhas-multas', ['status' => 'paga']));

        $response->assertStatus(200);
    }

    public function testFinesPageShowsEmptyStateWhenNoFines(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('minhas-multas'));

        $response->assertStatus(200);
        $response->assertSee('Nenhuma multa encontrada');
    }

    public function testFinesPageDisplaysFineInformation(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $rental = Rental::factory()->create(['usuario_id' => $user->id]);
        $fine = Fine::factory()->create([
            'usuario_id' => $user->id,
            'aluguel_id' => $rental->id,
            'valor' => 15.75,
            'paga' => false,
        ]);

        $response = $this->actingAs($user)->get(route('minhas-multas'));

        $response->assertStatus(200);
        $response->assertSee('R$ 15,75');
        $response->assertSee($fine->rental->book->titulo);
        $response->assertSee('Pendente');
    }

    public function testFinesPageShowsSummaryCards(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $rental1 = Rental::factory()->create(['usuario_id' => $user->id]);
        $rental2 = Rental::factory()->create(['usuario_id' => $user->id]);

        Fine::factory()->create([
            'usuario_id' => $user->id,
            'aluguel_id' => $rental1->id,
            'paga' => false,
            'valor' => 20.00,
        ]);
        Fine::factory()->create([
            'usuario_id' => $user->id,
            'aluguel_id' => $rental2->id,
            'paga' => true,
            'valor' => 15.00,
        ]);

        $response = $this->actingAs($user)->get(route('minhas-multas'));

        $response->assertStatus(200);
        $response->assertSee('Multas Pendentes');
        $response->assertSee('Multas Pagas');
        $response->assertSee('Total Pendente');
    }
}
