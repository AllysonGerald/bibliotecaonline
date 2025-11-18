<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Fine;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FineFactory extends Factory
{
    protected $model = Fine::class;

    public function definition(): array
    {
        return [
            'aluguel_id' => Rental::factory(),
            'usuario_id' => User::factory(),
            'valor' => fake()->randomFloat(2, 5, 100),
            'paga' => fake()->boolean(30), // 30% chance de estar paga
            'paga_em' => fake()->optional(0.3)->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
