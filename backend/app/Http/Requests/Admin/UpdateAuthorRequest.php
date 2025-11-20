<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request de validação para atualização de autor.
 */
class UpdateAuthorRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool True se o usuário for administrador
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Retorna as mensagens de erro personalizadas para as regras de validação.
     *
     * @return array<string, string> Mensagens de erro
     */
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

    /**
     * Retorna as regras de validação para a requisição.
     *
     * @return array<string, array<int, string>> Regras de validação
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'biografia' => ['nullable', 'string', 'max:5000'],
            'data_nascimento' => ['nullable', 'date', 'before:today'],
            'foto' => ['nullable', 'string', 'max:255'],
        ];
    }
}
