<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthenticatedUserCanCreateReview(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('avaliacoes.store', $book), [
            'nota' => 5,
            'comentario' => 'Excelente livro!',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Avaliação enviada com sucesso!');
        $this->assertDatabaseHas('avaliacoes', [
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'nota' => 5,
            'comentario' => 'Excelente livro!',
        ]);
    }

    public function testGuestCannotCreateReview(): void
    {
        $book = Book::factory()->create();

        $response = $this->post(route('avaliacoes.store', $book), [
            'nota' => 5,
            'comentario' => 'Excelente livro!',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function testReviewCanBeCreatedWithoutComment(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('avaliacoes.store', $book), [
            'nota' => 4,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Avaliação enviada com sucesso!');
        $this->assertDatabaseHas('avaliacoes', [
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'nota' => 4,
            'comentario' => null,
        ]);
    }

    public function testReviewValidationRatingMustBeBetween1And5(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('avaliacoes.store', $book), [
            'nota' => 6,
            'comentario' => 'Nota inválida',
        ]);

        $response->assertSessionHasErrors(['nota']);
    }

    public function testReviewValidationRequiresRating(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user)->post(route('avaliacoes.store', $book), [
            'comentario' => 'Sem nota',
        ]);

        $response->assertSessionHasErrors(['nota']);
    }

    public function testUserCanDeleteOwnReview(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $review = Review::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
        ]);

        $response = $this->actingAs($user)->delete(route('avaliacoes.destroy', $review));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Avaliação removida com sucesso!');
        $this->assertDatabaseMissing('avaliacoes', [
            'id' => $review->id,
        ]);
    }

    public function testUserCannotCreateDuplicateReview(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();
        Review::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
        ]);

        $response = $this->actingAs($user)->post(route('avaliacoes.store', $book), [
            'nota' => 4,
            'comentario' => 'Outra avaliação',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Você já avaliou este livro. Você pode editar sua avaliação existente.');
        $this->assertDatabaseCount('avaliacoes', 1);
    }

    public function testUserCannotDeleteOtherUserReview(): void
    {
        /** @var User $user1 */
        $user1 = User::factory()->create();
        /** @var User $user2 */
        $user2 = User::factory()->create();
        $book = Book::factory()->create();
        $review = Review::factory()->create([
            'usuario_id' => $user2->id,
            'livro_id' => $book->id,
        ]);

        $response = $this->actingAs($user1)->delete(route('avaliacoes.destroy', $review));

        $response->assertStatus(403);
        $this->assertDatabaseHas('avaliacoes', [
            'id' => $review->id,
        ]);
    }

    public function testUserCannotUpdateOtherUserReview(): void
    {
        /** @var User $user1 */
        $user1 = User::factory()->create();
        /** @var User $user2 */
        $user2 = User::factory()->create();
        $book = Book::factory()->create();
        $review = Review::factory()->create([
            'usuario_id' => $user2->id,
            'livro_id' => $book->id,
        ]);

        $response = $this->actingAs($user1)->put(route('avaliacoes.update', $review), [
            'nota' => 5,
            'comentario' => 'Tentativa de editar',
        ]);

        $response->assertStatus(403);
    }

    public function testUserCanUpdateOwnReview(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $review = Review::factory()->create([
            'usuario_id' => $user->id,
            'livro_id' => $book->id,
            'nota' => 3,
            'comentario' => 'Comentário antigo',
        ]);

        $response = $this->actingAs($user)->put(route('avaliacoes.update', $review), [
            'nota' => 5,
            'comentario' => 'Comentário atualizado',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Avaliação atualizada com sucesso!');
        $this->assertDatabaseHas('avaliacoes', [
            'id' => $review->id,
            'nota' => 5,
            'comentario' => 'Comentário atualizado',
        ]);
    }
}
