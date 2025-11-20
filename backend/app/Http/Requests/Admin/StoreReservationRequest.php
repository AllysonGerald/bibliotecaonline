<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\ReservationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function messages(): array
    {
        return [
            'usuario_id.required' => 'O campo usuário é obrigatório.',
            'usuario_id.exists' => 'O usuário selecionado não existe.',
            'livro_id.required' => 'O campo livro é obrigatório.',
            'livro_id.exists' => 'O livro selecionado não existe.',
            'reservado_em.required' => 'O campo data de reserva é obrigatório.',
            'reservado_em.date' => 'A data de reserva deve ser uma data válida.',
            'expira_em.required' => 'O campo data de expiração é obrigatório.',
            'expira_em.date' => 'A data de expiração deve ser uma data válida.',
            'expira_em.after' => 'A data de expiração deve ser posterior à data de reserva.',
            'status.required' => 'O campo status é obrigatório.',
        ];
    }

    public function rules(): array
    {
        return [
            'usuario_id' => ['required', 'integer', 'exists:users,id'],
            'livro_id' => ['required', 'integer', 'exists:livros,id'],
            'reservado_em' => ['required', 'date'],
            'expira_em' => ['required', 'date', 'after:reservado_em'],
            'status' => ['required', new Enum(ReservationStatus::class)],
        ];
    }
}
