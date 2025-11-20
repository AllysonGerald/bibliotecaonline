<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Enums\RentalStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateRentalRequest extends FormRequest
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
            'alugado_em.required' => 'O campo data de aluguel é obrigatório.',
            'alugado_em.date' => 'A data de aluguel deve ser uma data válida.',
            'data_devolucao.required' => 'O campo data de devolução é obrigatório.',
            'data_devolucao.date' => 'A data de devolução deve ser uma data válida.',
            'data_devolucao.after' => 'A data de devolução deve ser posterior à data de aluguel.',
            'devolvido_em.date' => 'A data de devolução efetiva deve ser uma data válida.',
            'devolvido_em.after_or_equal' => 'A data de devolução efetiva deve ser igual ou posterior à data de aluguel.',
            'taxa_atraso.numeric' => 'A taxa de atraso deve ser um número.',
            'taxa_atraso.min' => 'A taxa de atraso não pode ser negativa.',
            'status.required' => 'O campo status é obrigatório.',
        ];
    }

    public function rules(): array
    {
        return [
            'usuario_id' => ['required', 'integer', 'exists:users,id'],
            'livro_id' => ['required', 'integer', 'exists:livros,id'],
            'alugado_em' => ['required', 'date'],
            'data_devolucao' => ['required', 'date', 'after:alugado_em'],
            'devolvido_em' => ['nullable', 'date', 'after_or_equal:alugado_em'],
            'taxa_atraso' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', new Enum(RentalStatus::class)],
        ];
    }
}
