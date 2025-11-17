<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ReservationStatus;
use App\Models\Book;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        $reservadoEm = fake()->dateTimeBetween('-1 month', 'now');
        $expiraEm = fake()->dateTimeBetween($reservadoEm, '+1 month');
        $status = ReservationStatus::PENDENTE;

        if (fake()->boolean(30)) { // 30% chance of being confirmed
            $status = ReservationStatus::CONFIRMADA;
        } elseif (fake()->boolean(20)) { // 20% chance of being cancelled
            $status = ReservationStatus::CANCELADA;
        } elseif (fake()->boolean(10) && $expiraEm < now()) { // 10% chance of being expired
            $status = ReservationStatus::EXPIRADA;
        }

        return [
            'usuario_id' => User::factory(),
            'livro_id' => Book::factory(),
            'reservado_em' => $reservadoEm,
            'expira_em' => $expiraEm,
            'status' => $status,
        ];
    }
}
