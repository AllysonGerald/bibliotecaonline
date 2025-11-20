<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'assunto' => fake()->sentence(3),
            'mensagem' => fake()->paragraph(5),
            'lido' => false,
            'lido_em' => null,
        ];
    }

    public function read(): static
    {
        // Laravel requer closures não-estáticas para $this->state() funcionar com bindTo()
        return $this->state(fn (array $attributes) => [
            'lido' => true,
            'lido_em' => now(),
        ]);
    }

    public function unread(): static
    {
        // Laravel requer closures não-estáticas para $this->state() funcionar com bindTo()
        return $this->state(fn (array $attributes) => [
            'lido' => false,
            'lido_em' => null,
        ]);
    }
}

