<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function admin(): static
    {
        // Laravel requer closures não-estáticas para $this->state() funcionar com bindTo()
        return $this->state(fn (array $attributes) => [
            'papel' => UserRole::ADMIN,
        ]);
    }

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'papel' => UserRole::USUARIO,
            'ativo' => true,
            'telefone' => fake()->optional()->phoneNumber(),
        ];
    }

    public function inactive(): static
    {
        // Laravel requer closures não-estáticas para $this->state() funcionar com bindTo()
        return $this->state(fn (array $attributes) => [
            'ativo' => false,
        ]);
    }

    public function unverified(): static
    {
        // Laravel requer closures não-estáticas para $this->state() funcionar com bindTo()
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
