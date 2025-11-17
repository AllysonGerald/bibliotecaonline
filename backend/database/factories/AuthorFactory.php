<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'biografia' => fake()->paragraph(3),
            'data_nascimento' => fake()->date('Y-m-d', '-100 years'),
        ];
    }
}
