<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\BookStatus;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'titulo' => fake()->sentence(3),
            'descricao' => fake()->paragraph(3),
            'autor_id' => Author::factory(),
            'categoria_id' => Category::factory(),
            'isbn' => fake()->unique()->isbn13(),
            'editora' => fake()->company(),
            'ano_publicacao' => fake()->numberBetween(1900, (int) date('Y')),
            'paginas' => fake()->numberBetween(100, 1000),
            'preco' => fake()->randomFloat(2, 10, 200),
            'status' => fake()->randomElement(BookStatus::cases())->value,
            'quantidade' => fake()->numberBetween(0, 20),
        ];
    }
}
