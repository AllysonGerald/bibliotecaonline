<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request de validação para login de usuário.
 */
class LoginRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     *
     * @return bool Sempre retorna true (público)
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Retorna as mensagens de erro personalizadas para as regras de validação.
     *
     * @return array<string, string> Mensagens de erro
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'password.required' => 'O campo senha é obrigatório.',
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
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ];
    }
}
