<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\RentalStatus;
use App\Models\Book;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentalFactory extends Factory
{
    protected $model = Rental::class;

    public function definition(): array
    {
        $alugadoEm = fake()->dateTimeBetween('-30 days', 'now');
        $dataDevolucao = fake()->dateTimeBetween($alugadoEm, '+30 days');

        return [
            'usuario_id' => User::factory(),
            'livro_id' => Book::factory(),
            'alugado_em' => $alugadoEm,
            'data_devolucao' => $dataDevolucao,
            'devolvido_em' => fake()->optional(0.3)->dateTimeBetween($alugadoEm, 'now'),
            'taxa_atraso' => fake()->randomFloat(2, 0, 50),
            'status' => fake()->randomElement(RentalStatus::cases())->value,
        ];
    }
}
