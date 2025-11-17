<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'biografia' => ['nullable', 'string', 'max:5000'],
            'data_nascimento' => ['nullable', 'date', 'before:today'],
            'foto' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do autor é obrigatório.',
            'nome.max' => 'O nome do autor não pode ter mais de 255 caracteres.',
            'biografia.max' => 'A biografia não pode ter mais de 5000 caracteres.',
            'data_nascimento.date' => 'A data de nascimento deve ser uma data válida.',
            'data_nascimento.before' => 'A data de nascimento deve ser anterior a hoje.',
            'foto.max' => 'O caminho da foto não pode ter mais de 255 caracteres.',
        ];
    }
}
