<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'usuario_id' => User::factory(),
            'livro_id' => Book::factory(),
            'nota' => fake()->numberBetween(1, 5),
            'comentario' => fake()->optional(0.7)->paragraph(),
        ];
    }
}
